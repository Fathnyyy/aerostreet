<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin dengan data dari database.
     */
    public function index()
    {
        $stats = [
            // Revenue & Orders: 0 karena tabel orders belum diimplementasi
            'totalRevenue'   => 'Rp 0',
            'totalOrders'    => 0,

            // Data asli dari database
            'totalProducts'  => Product::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
