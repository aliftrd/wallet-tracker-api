<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/v1/auth')
    ->namespace('App\Http\Controllers\Api\V1\Auth')
    ->group(function () {
        Route::post('/login', 'LoginController');
        Route::post('/register', 'RegisterController');
    });

Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->group(function () {
        Route::apiResources([
            'wallets' => 'WalletController',
            'categories' => 'CategoryController',
        ]);
    });
