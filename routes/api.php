<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\MpesaWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// M-Pesa Integration
Route::prefix('mpesa')->group(function () {
    Route::post('/callback', [MpesaWebhookController::class, 'callback'])
        ->name('api.mpesa.callback');
});

// Order Tracking (authenticated)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders/{order}/track', [TrackingController::class, 'track'])
        ->name('api.orders.track');
    Route::get('/orders/{order}/status', [TrackingController::class, 'status'])
        ->name('api.orders.status');
});
