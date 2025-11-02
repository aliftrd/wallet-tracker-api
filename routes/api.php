<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/v1/auth')
    ->namespace('App\Http\Controllers\Api\V1\Auth')
    ->group(function () {
        Route::post('/login', 'LoginController');
        Route::post('/register', 'RegisterController');
    });

Route::middleware('auth:api')
    ->prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->group(function () {
        Route::apiResource('wallets', 'WalletController');
        Route::apiResource('categories', 'UserCategoryController')->parameters(['categories' => 'userCategory']);
    });
