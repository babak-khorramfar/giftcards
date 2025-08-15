<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderWebhookController;

Route::post('/provider/webhook', [ProviderWebhookController::class, 'handle'])
    ->name('provider.webhook');
