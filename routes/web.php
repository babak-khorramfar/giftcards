<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Breeze default routes ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';

// --- Custom app routes (restored) ---

// Health check
Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'time'   => now()->toIso8601String(),
]));

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->whereAlphaNumeric('slug')
    ->name('products.show');

// Checkout
Route::get('/checkout', fn () => 'Checkout / Payment')->name('checkout.index');

// Orders
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// Admin (placeholder)
Route::get('/admin', fn () => 'Admin Panel')->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    // ...
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
});