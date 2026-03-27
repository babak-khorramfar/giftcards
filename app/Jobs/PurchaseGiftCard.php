<?php

// app/Jobs/PurchaseGiftCard.php
namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseGiftCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function handle(): void
    {
        $endpoint = config('services.gift_provider.purchase_url');
        $apiKey   = config('services.gift_provider.api_key');

        $payload = [
            'our_order_id' => $this->order->id,
            'amount'       => $this->order->total,
            'currency'     => $this->order->currency,
            'callback_url' => route('provider.webhook'), // /api/provider/webhook
            // ... سایر فیلدهای لازم Provider
        ];

        try {
            // نمونه: درخواست به Provider (در عمل، URL واقعی)
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Accept'        => 'application/json',
            ])->post($endpoint, $payload);

            $body = $response->json() ?? [];

            $this->order->update([
                'provider'          => config('services.gift_provider.name'),
                'provider_order_id' => $body['data']['id'] ?? null,
                'meta'              => $body,
            ]);

            // نتیجه نهایی معمولاً با وبهوک می‌آید.

        } catch (\Throwable $e) {
            $this->order->update([
                'status'        => Order::STATUS_CANCELED,
                'error_code'    => 'HTTP_EXCEPTION',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
