<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{slug}', [CartController::class, 'addToCart'])->name('cart.add'); // Disini slug gak kepake di controller, tapi biar route valid aja
    Route::patch('/cart/{id}', [CartController::class, 'updateQuantity'])->name('cart.update'); // Pakai PATCH untuk update qty
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});
