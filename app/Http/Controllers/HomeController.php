<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // فعلاً فقط یک متن تستی برمی‌گردونیم
        // بعداً اینجا محصولات، دسته‌بندی‌ها و غیره رو لود می‌کنیم
        return view('home', [
            'title' => 'صفحه اصلی سایت',
        ]);
    }
}
