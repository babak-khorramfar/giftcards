<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // GET /orders  → لیست سفارش‌های کاربر
    public function index(Request $request)
    {
        $status = $request->query('status'); // optional
        $q = Order::query()->where('user_id', auth()->id());

        if ($status && in_array($status, Order::STATUSES, true)) {
            $q->where('status', $status);
        }

        $orders = $q->latest()->paginate(15)->withQueryString();

        return view('orders.index', compact('orders', 'status'));
    }

    // GET /orders/{id}  → جزئیات سفارش
    public function show(int $id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // POST /orders  → ثبت سفارش و تماس مستقیم با Provider (نسخه بدون صف)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total'    => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);

        $order = Order::create([
            'user_id'  => auth()->id(),
            'total'    => $validated['total'],
            'currency' => strtoupper($validated['currency']),
            'status'   => Order::STATUS_PROCESSING,
        ]);

        // تماس تستی با Mock (همان‌طور که مرحله قبل گفتیم)
        try {
            $endpoint = config('services.gift_provider.purchase_url');
            $apiKey   = config('services.gift_provider.api_key');

            $payload = [
                'our_order_id' => $order->id,
                'amount'       => $order->total,
                'currency'     => $order->currency,
            ];

            $body = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => "Bearer {$apiKey}",
                    'Accept'        => 'application/json',
                ])
                ->timeout(10)
                ->post($endpoint, $payload)
                ->throw()
                ->json();

            $providerStatus   = data_get($body, 'data.status');      // success|canceled|...
            $providerOrderId  = data_get($body, 'data.id');
            $cardCode         = data_get($body, 'data.card_code');

            $newStatus = match ($providerStatus) {
                'success'  => Order::STATUS_COMPLETED,
                'canceled' => Order::STATUS_CANCELED,
                default    => Order::STATUS_PROCESSING,
            };

            $meta = $order->meta ?? [];
            if ($cardCode) $meta['card_code'] = $cardCode;

            $order->update([
                'provider'          => config('services.gift_provider.name'),
                'provider_order_id' => $providerOrderId,
                'status'            => $newStatus,
                'meta'              => array_merge($meta, $body ?? []),
            ]);
        } catch (\Throwable $e) {
            $order->update([
                'status'        => Order::STATUS_CANCELED,
                'error_code'    => 'HTTP_EXCEPTION',
                'error_message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'سفارش ثبت شد. وضعیت فعلی به‌روز شد.');
    }
}
