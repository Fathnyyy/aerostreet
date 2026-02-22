<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan Halaman Keranjang
     */
    public function index()
    {
        $carts = Cart::with('product')
                     ->where('user_id', Auth::id())
                     ->get();

        return view('cart.index', compact('carts'));
    }

    /**
     * Tambah ke Keranjang (Add to Cart)
     * - Stock Guard: Cek stok real-time dari product_sizes
     * - Smart Merge: Jika item + size sama sudah ada, tambahkan qty saja
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size'       => 'required|string',
        ]);

        $user_id    = Auth::id();
        $product_id = $request->product_id;
        $size       = $request->size;
        $quantity   = 1;

        // 1. STOCK GUARD — Cek apakah size valid & stok tersedia
        $productSize = ProductSize::where('product_id', $product_id)
                                  ->where('size', $size)
                                  ->first();

        if (!$productSize || $productSize->stock < $quantity) {
            return back()->with('error', 'Sorry, this size is out of stock.');
        }

        // 2. SMART MERGE — Cek apakah item sudah ada di keranjang
        $existingCart = Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->where('size', $size)
                            ->first();

        if ($existingCart) {
            // Item sudah ada → cek stok cukup untuk increment
            $newQty = $existingCart->quantity + $quantity;
            if ($productSize->stock >= $newQty) {
                $existingCart->increment('quantity');
                return redirect()->route('cart.index')
                       ->with('success', 'Item quantity updated in your cart.');
            } else {
                return back()->with('error', 'Maximum stock reached for this size.');
            }
        }

        // 3. Buat baris baru di keranjang
        Cart::create([
            'user_id'    => $user_id,
            'product_id' => $product_id,
            'size'       => $size,
            'quantity'   => $quantity,
        ]);

        return redirect()->route('cart.index')
               ->with('success', 'Item added to your cart!');
    }

    /**
     * Update Jumlah (Plus / Minus)
     * - Stock Guard tetap aktif saat (+)
     * - Auto-remove jika qty = 1 lalu tekan (-)
     */
    public function updateQuantity(Request $request, $id)
    {
        $item = Cart::where('user_id', Auth::id())->findOrFail($id);
        $type = $request->type; // 'plus' or 'minus'

        if ($type === 'plus') {
            // STOCK GUARD — Cek stok real-time sebelum tambah
            $productSize = ProductSize::where('product_id', $item->product_id)
                                      ->where('size', $item->size)
                                      ->first();

            if ($productSize && $productSize->stock > $item->quantity) {
                $item->increment('quantity');
            } else {
                return back()->with('error', 'Maximum stock reached for this size.');
            }
        } elseif ($type === 'minus') {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                // Qty = 1, tekan minus = hapus dari keranjang
                $item->delete();
                return back()->with('success', 'Item removed from your cart.');
            }
        }

        return back();
    }

    /**
     * Hapus Item dari Keranjang
     */
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Item removed from your cart.');
    }
}
