<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses Tamu & Member)
|--------------------------------------------------------------------------
*/

// Halaman Utama (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/faq', fn() => view('faq'))->name('faq');

// Allow logout via GET (Fixes 419 issues/Manual URL entry)
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 2. CUSTOMER ROUTES (Wajib Login & Verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard User (Setelah Login masuk sini)
    Route::get('/dashboard', function () {
        $user   = Auth::user();
        $orders = \App\Models\Order::where('user_id', $user->id)
                    ->with('items.product')
                    ->latest()
                    ->get();

        $stats = [
            'pending'    => $orders->whereIn('status', ['pending', 'pending_verification'])->count(),
            'paid'       => $orders->where('status', 'paid')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'shipped'    => $orders->where('status', 'shipped')->count(),
            'completed'  => $orders->where('status', 'completed')->count(),
            'total'      => $orders->count(),
        ];

        $recentOrders = $orders->take(5);

        return view('dashboard', compact('orders', 'stats', 'recentOrders'));
    })->name('dashboard');


    // Profile Settings (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout & Payment Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.process');
    Route::get('/checkout/{order}/midtrans', [CheckoutController::class, 'midtransPage'])->name('checkout.midtrans');
    Route::get('/checkout/{order}/manual', [CheckoutController::class, 'manualPage'])->name('checkout.manual');
    Route::post('/checkout/{order}/upload-proof', [CheckoutController::class, 'uploadProof'])->name('checkout.upload-proof');

    // ================================================================
    // PENGGANTI WEBHOOK — Target fetch() dari onSuccess Snap.js
    // Karena localhost demo (tanpa ngrok), tidak pakai webhook eksternal
    // ================================================================
    Route::post('/checkout/{order}/midtrans-success', [CheckoutController::class, 'midtransSuccess'])->name('checkout.midtrans.success');

    // Review Routes
    Route::get('/reviews/{order}/{product}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (Area Terlarang — Khusus Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Produk
    Route::resource('products', AdminProductController::class);

    // Orders Management (berbasis tabel orders — bukan cart)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login, Register, Lupa Password)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
require __DIR__.'/cart.php';

// ================================================================
// Catatan: Webhook Midtrans DIHAPUS karena proyek ini berjalan di
// localhost (demo Tugas Akhir) tanpa ngrok. Update status order
// dilakukan melalui Route::post checkout.midtrans.success di atas,
// yang dipanggil langsung oleh fetch() dari onSuccess Snap.js.
// ================================================================