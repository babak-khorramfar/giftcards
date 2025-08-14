<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiftCard;

class ProductController extends Controller
{
    public function index()
    {
        // فعلاً همه گیفت‌کارت‌ها را لود می‌کنیم (بعداً صفحه‌بندی و فیلتر اضافه می‌شود)
        $products = GiftCard::all();

        return view('products.index', [
            'title' => 'لیست محصولات',
            'products' => $products
        ]);
    }

    public function show(string $slug)
{
    $product = GiftCard::where('slug', $slug)->firstOrFail();

    return view('products.show', [
        'title' => $product->name,
        'product' => $product
    ]);
}
}
