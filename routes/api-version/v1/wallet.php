<?php

use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(
    fn() => Route::apiResource('wallets', WalletController::class)
);
