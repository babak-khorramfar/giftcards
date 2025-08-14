<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $validated = $request->validate([
            'total'    => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        // ایجاد سفارش
        $order = Order::create([
            'user_id' => auth()->id(), // در صورت ورود کاربر
            'total'   => $validated['total'],
            'currency'=> $validated['currency'],
            'status'  => 'pending',
        ]);

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'سفارش با موفقیت ثبت شد.');
    }

    public function show(int $id)
    {
        $order = Order::findOrFail($id);

        return view('orders.show', [
            'title' => 'جزئیات سفارش',
            'order' => $order
        ]);
    }

    public function index()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', [
            'title'  => 'سفارش‌های من',
            'orders' => $orders,
        ]);
    }

}
