<?php

use App\Http\Controllers\Api\V1\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    UpdateFcmTokenController,
    LogoutController,
};
use Illuminate\Support\Facades\Route;

Route::middleware('api-key')
    ->prefix('v1')
    ->group(function () {
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
        Route::post('forgot-password', ForgotPasswordController::class);

        Route::middleware('auth:api')->group(function () {
            // Route::get('me', GetMeController::class);
            Route::match(['put', 'patch'], 'me/fcm-token', UpdateFcmTokenController::class);
            Route::delete('logout', LogoutController::class);
        });
    });
