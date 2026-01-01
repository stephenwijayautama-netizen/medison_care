<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentCallbackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Payment Callback (Dari Doku) - Sebaiknya di luar middleware auth jika Doku yang panggil
Route::post('/payment/callback', [PaymentCallbackController::class, 'handle']);