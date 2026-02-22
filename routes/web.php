<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses Tamu & Member)
|--------------------------------------------------------------------------
*/

// Halaman Utama (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

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
        return view('dashboard');
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

    // Orders (Cart-based)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

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

/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK (Tanpa CSRF — Harus accessible dari server Midtrans)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [CheckoutController::class, 'midtransCallback'])
     ->name('midtrans.callback')
     ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);