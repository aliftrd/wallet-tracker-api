<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api\V1\Auth')
    ->prefix('v1')
    ->group(function () {
        Route::prefix('auth')
            ->group(function () {
                Route::post('/login', 'LoginController');
                Route::post('/register', 'RegisterController');
            });


        Route::middleware('auth:api')
            ->group(function () {
                Route::get('/me', 'ProfileController');
                Route::match(['put', 'patch'], '/me', 'UpdateProfileController');
                Route::match(['put', 'patch'], '/update-password', 'UpdatePasswordController');
                Route::delete('/logout', 'LogoutController');
            });
    });

Route::middleware('auth:api')
    ->prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->group(function () {
        Route::apiResource('wallets', 'WalletController');
        Route::apiResource('categories', 'UserCategoryController')->parameters(['categories' => 'userCategory']);
        Route::apiResource('transactions', 'TransactionController');
    });
