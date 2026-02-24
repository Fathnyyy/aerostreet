<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Tampilkan form review untuk sebuah item dari order selesai
     * GET /reviews/{order}/{product}
     */
    public function create(Order $order, $productId)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== Auth::id(), 403);

        // Pastikan order sudah completed atau shipped
        abort_if(!in_array($order->status, ['completed', 'shipped']), 403, 'Pesanan belum selesai.');

        // Cek produk ada dalam order
        $orderItem = $order->items()->where('product_id', $productId)->first();
        abort_if(!$orderItem, 404, 'Produk tidak ditemukan dalam pesanan ini.');

        // Cek sudah pernah review belum
        $existing = Review::where([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'order_id'   => $order->id,
        ])->first();

        if ($existing) {
            return redirect()->route('dashboard')
                ->with('info', 'Kamu sudah memberikan ulasan untuk produk ini.');
        }

        return view('reviews.create', compact('order', 'orderItem'));
    }

    /**
     * Simpan review baru
     * POST /reviews
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'title'      => 'nullable|string|max:100',
            'body'       => 'nullable|string|max:1000',
            'size_fit'   => 'nullable|integer|in:1,2,3',
            'photos.*'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072', // max 3MB per foto
            'photos'     => 'nullable|array|max:4',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Security: pastikan order milik user yang login
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if(!in_array($order->status, ['completed', 'shipped']), 403);

        // Cek duplikasi
        $exists = Review::where([
            'user_id'    => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id'   => $validated['order_id'],
        ])->exists();

        if ($exists) {
            return back()->with('error', 'Kamu sudah mengulas produk ini.');
        }

        // Upload foto (max 4)
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $photoPaths[] = $path;
            }
        }

        Review::create([
            'user_id'            => Auth::id(),
            'product_id'         => $validated['product_id'],
            'order_id'           => $validated['order_id'],
            'rating'             => $validated['rating'],
            'title'              => $validated['title'] ?? null,
            'body'               => $validated['body'] ?? null,
            'photos'             => count($photoPaths) ? $photoPaths : null,
            'size_fit'           => $validated['size_fit'] ?? null,
            'verified_purchase'  => true,
            'status'             => 'approved',
        ]);

        return redirect()->route('dashboard')
            ->with('success', '⭐ Ulasan kamu berhasil dikirim! Terima kasih sudah berbagi.');
    }

    /**
     * Hapus review milik user sendiri
     * DELETE /reviews/{review}
     */
    public function destroy(Review $review)
    {
        abort_if($review->user_id !== Auth::id(), 403);

        // Hapus foto dari storage
        if ($review->photos) {
            foreach ($review->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
