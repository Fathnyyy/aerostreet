<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan (cart items grouped by user).
     * Karena belum ada tabel orders, kita tampilkan cart aktif per user sebagai "pending orders".
     */
    public function index(Request $request)
    {
        // Ambil semua cart items dengan relasi user dan product
        $query = Cart::with(['user', 'product'])
                     ->latest();

        // Filter by search (nama user atau produk)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('product', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $cartItems = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'totalItems'    => Cart::count(),
            'totalUsers'    => Cart::distinct('user_id')->count('user_id'),
            'totalRevenue'  => Cart::with('product')->get()->sum(fn($c) => $c->product ? $c->product->price * $c->quantity : 0),
            'totalQuantity' => Cart::sum('quantity'),
        ];

        return view('admin.orders.index', compact('cartItems', 'stats'));
    }
}
