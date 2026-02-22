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

        // Buat Order dan Order Items dalam satu transaksi database
        DB::beginTransaction();
        try {
            // Buat record Order baru
            $order = Order::create([
                'user_id'        => $user->id,
                'order_number'   => Order::generateOrderNumber(),
                'total_price'    => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            // Pindahkan item dari Cart ke OrderItem
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cart->product_id,
                    'size'       => $cart->size,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price, // snapshot harga
                ]);
            }

            // Kosongkan Cart user
            Cart::where('user_id', $user->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->route('cart.index')
                             ->with('error', 'Checkout failed. Please try again.');
        }

        // Route ke pembayaran sesuai metode
        if ($request->payment_method === 'midtrans') {
            return $this->processMidtrans($order, $user, $carts, $total);
        }

        // Manual transfer
        return redirect()->route('checkout.manual', $order)
                         ->with('success', 'Order created! Please complete your transfer.');
    }

    /**
     * Generate Snap Token Midtrans dan redirect ke halaman pembayaran
     */
    private function processMidtrans(Order $order, $user, $carts, float $total)
    {
        try {
            // Build item details untuk Midtrans
            $itemDetails = $carts->map(function ($cart) {
                return [
                    'id'       => 'PROD-' . $cart->product_id,
                    'price'    => (int) round($cart->product->price),
                    'quantity' => $cart->quantity,
                    'name'     => substr($cart->product->name . ' (' . $cart->size . ')', 0, 50),
                ];
            })->toArray();

            // Tambahkan item pajak
            $taxAmount = (int) round($total * 0.11 / 1.11); // Tax dari total
            $itemDetails[] = [
                'id'       => 'TAX-PPN',
                'price'    => (int) round($total - collect($itemDetails)->sum(fn($i) => $i['price'] * $i['quantity'])),
                'quantity' => 1,
                'name'     => 'Tax (PPN 11%)',
            ];

            $params = [
                'transaction_details' => [
                    'order_id'      => $order->order_number,
                    'gross_amount'  => (int) round($total),
                ],
                'customer_details' => [
                    'name'  => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token ke database
            $order->update(['snap_token' => $snapToken]);

            return redirect()->route('checkout.midtrans', $order);
        } catch (\Exception $e) {
            Log::error('Midtrans token error: ' . $e->getMessage());
            // Fallback: batalkan order jika gagal dapat token
            $order->update(['status' => 'cancelled']);
            return redirect()->route('cart.index')
                             ->with('error', 'Payment gateway error. Please try again.');
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
            'payment_proof' => 'required|image|mimes:jpeg,jpg,png|max:5120', // Max 5MB
        ]);

        // Simpan file ke storage/app/public/payment-proofs
        $path = $request->file('payment_proof')
                        ->store('payment-proofs', 'public');

        $order->update([
            'payment_proof' => $path,
            'status'        => 'pending_verification',
        ]);

        return redirect()->route('dashboard')
                         ->with('success', 'Payment proof uploaded! We will verify your payment within 1x24 hours.');
    }

    /**
     * Webhook Callback dari Midtrans
     * POST /midtrans/callback
     * (Dikecualikan dari CSRF di bootstrap/app.php)
     */
    public function midtransCallback(Request $request)
    {
        $payload = $request->all();

        // Verifikasi signature untuk keamanan
        $serverKey         = config('midtrans.server_key');
        $orderId           = $payload['order_id'] ?? '';
        $statusCode        = $payload['status_code'] ?? '';
        $grossAmount       = $payload['gross_amount'] ?? '';
        $signatureKey      = $payload['signature_key'] ?? '';
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans invalid signature for order: ' . $orderId);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari order berdasarkan order_number
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';
        $transactionId     = $payload['transaction_id'] ?? null;

        // Update status berdasarkan response Midtrans
        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $order->update([
                'status'                   => 'paid',
                'midtrans_transaction_id'  => $transactionId,
            ]);
        } elseif ($transactionStatus === 'settlement') {
            $order->update([
                'status'                   => 'paid',
                'midtrans_transaction_id'  => $transactionId,
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'cancelled']);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['status' => 'pending']);
        }

        Log::info("Midtrans callback: Order {$orderId} → status: {$transactionStatus}");

        return response()->json(['message' => 'OK'], 200);
    }
}
