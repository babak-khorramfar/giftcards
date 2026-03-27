<?php

// app/Http/Controllers/ProviderWebhookController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProviderWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1) تأیید امضا/توکن — بسته به مستندات Provider
        // مثال ساده: مقایسه یک Secret
        $signature = $request->header('X-Provider-Signature');
        if ($signature !== config('services.gift_provider.webhook_secret')) {
            return response()->json(['message' => 'Invalid signature'], Response::HTTP_FORBIDDEN);
        }

        // 2) استخراج داده‌ها — بر اساس مستندات واقعی Provider
        $providerOrderId = $request->input('data.id');
        $status          = $request->input('data.status'); // success|failed|canceled|...
        $code            = $request->input('data.card_code'); // اگر کارت کد بده

        // 3) یافتن سفارش ما
        $order = Order::where('provider_order_id', $providerOrderId)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        // 4) به‌روزرسانی وضعیت
        if ($status === 'success') {
            $order->update([
                'status' => Order::STATUS_COMPLETED,
                'meta'   => array_merge($order->meta ?? [], ['card_code' => $code]),
            ]);
        } else {
            $order->update([
                'status'        => Order::STATUS_CANCELED,
                'error_code'    => $request->input('error.code'),
                'error_message' => $request->input('error.message'),
                'meta'          => array_merge($order->meta ?? [], $request->all()),
            ]);
        }

        // 5) پاسخ 200
        return response()->json(['message' => 'ok']);
    }
}

