<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Konstruktor — Setup konfigurasi Midtrans
     */
    public function __construct()
    {
        MidtransConfig::$serverKey    = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized  = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds        = config('midtrans.is_3ds');

        // FIX: Windows localhost tidak punya CA certificate bundle
        // Matikan SSL verification untuk development environment saja
        // JANGAN gunakan di production!
        if (!config('midtrans.is_production')) {
            MidtransConfig::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER     => [],
            ];
        }
    }

    /**
     * Tampilkan halaman checkout
     * GET /checkout
     */
    public function index()
    {
        $carts = Cart::with('product')
                     ->where('user_id', Auth::id())
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty. Add items before checking out.');
        }

        $subtotal   = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $tax        = $subtotal * 0.11;
        $total      = $subtotal + $tax;

        return view('checkout.index', compact('carts', 'subtotal', 'tax', 'total'));
    }

    /**
     * Proses checkout & buat order
     * POST /checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:midtrans,manual',
        ]);

        $user  = Auth::user();
        $carts = Cart::with('product')
                     ->where('user_id', $user->id)
                     ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty.');
        }

        // Hitung total
        $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $tax      = $subtotal * 0.11;
        $total    = $subtotal + $tax;

        // Buat Order dan Order Items
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => Order::generateOrderNumber(),
                'total_price'    => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'size'       => $cart->size,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price,
                ]);
            }

            // Untuk manual payment: hapus cart sekarang juga
            // Untuk Midtrans: cart dihapus SETELAH snap token berhasil
            if ($request->payment_method === 'manual') {
                Cart::where('user_id', $user->id)->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->route('cart.index')
                             ->with('error', 'Checkout failed. Please try again.');
        }

        // Route ke pembayaran
        if ($request->payment_method === 'midtrans') {
            return $this->processMidtrans($order, $user, $carts, $total);
        }

        return redirect()->route('checkout.manual', $order)
                         ->with('success', 'Order created! Please complete your transfer.');
    }

    /**
     * Generate Snap Token Midtrans dan redirect ke halaman pembayaran
     */
    private function processMidtrans(Order $order, $user, $carts, float $total)
    {
        try {
            $grossAmount = (int) round($total);

            // Build item details per produk
            $itemDetails = [];
            $itemsTotal  = 0;

            foreach ($carts as $cart) {
                $unitPrice    = (int) round($cart->product->price);
                $itemsTotal  += $unitPrice * $cart->quantity;
                $itemDetails[] = [
                    'id'       => 'PROD-' . $cart->product_id,
                    'price'    => $unitPrice,
                    'quantity' => $cart->quantity,
                    'name'     => substr($cart->product->name . ' (Size ' . $cart->size . ')', 0, 50),
                ];
            }

            // Hitung pajak sebagai selisih agar total PASTI cocok dengan gross_amount
            // Ini menghindari rounding mismatch yang ditolak Midtrans
            $taxAmount = $grossAmount - $itemsTotal;
            if ($taxAmount > 0) {
                $itemDetails[] = [
                    'id'       => 'TAX-PPN11',
                    'price'    => $taxAmount,
                    'quantity' => 1,
                    'name'     => 'Pajak PPN 11%',
                ];
            } elseif ($taxAmount < 0) {
                // Jika negatif (rounding edge case), adjust item pertama
                $itemDetails[0]['price'] += $taxAmount;
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->order_number,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
                'item_details' => $itemDetails,
            ];

            Log::info('Midtrans params', ['order' => $order->order_number, 'gross' => $grossAmount, 'items_sum' => collect($itemDetails)->sum(fn($i) => $i['price'] * $i['quantity'])]);

            $snapToken = Snap::getSnapToken($params);

            // Snap token berhasil — sekarang aman hapus cart
            Cart::where('user_id', $user->id)->delete();

            // Simpan snap token ke database
            $order->update(['snap_token' => $snapToken]);

            return redirect()->route('checkout.midtrans', $order);
        } catch (\Exception $e) {
            Log::error('Midtrans token error: ' . $e->getMessage(), [
                'order'  => $order->order_number,
                'trace'  => $e->getTraceAsString(),
            ]);
            // Kembalikan status order ke pending agar bisa dicoba lagi
            $order->update(['status' => 'pending']);
            return redirect()->route('cart.index')
                             ->with('error', 'Payment gateway error: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran Midtrans (Snap)
     * GET /checkout/{order}/midtrans
     */
    public function midtransPage(Order $order)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->payment_method !== 'midtrans', 404);

        return view('checkout.payment-midtrans', compact('order'));
    }

    /**
     * Tampilkan halaman upload bukti transfer manual
     * GET /checkout/{order}/manual
     */
    public function manualPage(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->payment_method !== 'manual', 404);

        return view('checkout.payment-manual', compact('order'));
    }

    /**
     * Upload bukti transfer
     * POST /checkout/{order}/upload-proof
     */
    public function uploadProof(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Max 2MB
        ]);

        // Hapus bukti lama jika ada (replace)
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        // Simpan file ke storage/app/public/payment-proofs
        $path = $request->file('payment_proof')
                        ->store('payment-proofs', 'public');

        $order->update([
            'payment_proof' => $path,
            'status'        => 'pending_verification',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Kami akan memverifikasi dalam 1×24 jam.');
    }

    /**
     * ============================================================
     * PENGGANTI WEBHOOK — Dipanggil via fetch() dari onSuccess Snap
     * POST /checkout/{order}/midtrans-success
     * ============================================================
     * Karena proyek ini berjalan di localhost tanpa ngrok,
     * webhook Midtrans tidak bisa diterima. Method ini dipanggil
     * langsung dari callback onSuccess() di frontend Snap.js.
     */
    public function midtransSuccess(Order $order)
    {
        // Pastikan order milik user yang sedang login
        abort_if($order->user_id !== Auth::id(), 403);

        // Hanya update jika order masih pending (hindari double-update)
        if ($order->status === 'pending') {
            $order->update(['status' => 'paid']);
            Log::info("Midtrans onSuccess (frontend): Order {$order->order_number} → paid");
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Order status updated to paid.',
        ]);
    }

}
