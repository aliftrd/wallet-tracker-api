<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', LoginController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'wallets' => WalletController::class,
        'categories' => CategoryController::class,
    ]);
});
