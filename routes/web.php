<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Breeze default / Home ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// احراز هویت Breeze
require __DIR__.'/auth.php';

// --- ناحیه عمومی (نیاز به لاگین ندارد) ---
// محصولات
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->whereAlphaNumeric('slug')
    ->name('products.show');

// Health check
Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'time'   => now()->toIso8601String(),
]));

// صفحه نمونه ادمین (بعداً جایگزین شود)
Route::get('/admin', fn () => 'Admin Panel')->name('admin.dashboard');

// --- ناحیه محافظت‌شده (لاگین + ایمیل وریفای) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // داشبورد
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // پروفایل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // سفارش‌ها (RESTful حداقلی)
    // لیست سفارش‌ها
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // ثبت سفارش
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // جزئیات سفارش
    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->whereNumber('id')
        ->name('orders.show');
});

// فقط برای تست — بعداً حذف کن
Route::post('/mock/purchase', function (\Illuminate\Http\Request $request) {
    // برای simulate موفقیت:
    return response()->json([
        'data' => [
            'id'         => 'prov_'.uniqid(),
            'status'     => 'success', // یا 'canceled' برای تست لغو
            'card_code'  => 'ABCD-EFGH-IJKL',
            'echo_order' => $request->input('our_order_id'),
        ],
    ]);
});