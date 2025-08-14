<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time'   => now()->toIso8601String(),
    ]);
});

// صفحات اصلی سایت (اسکلت اولیه با خروجی متنی؛ بعداً به کنترلر/ویو وصل می‌کنیم)
Route::get('/', fn () => 'Home Page')->name('home');

Route::get('/products', fn () => 'Products List')->name('products.index');
Route::get('/products/{slug}', fn (string $slug) => "Product Detail: {$slug}")
    ->whereAlphaNumeric('slug')
    ->name('products.show');

Route::get('/checkout', fn () => 'Checkout / Payment')->name('checkout.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => 'User Dashboard')->name('user.dashboard');
});

// پنل مدیریت (فعلاً placeholder؛ بعداً گارد دسترسی می‌گذاریم)
Route::get('/admin', fn () => 'Admin Panel')->name('admin.dashboard');