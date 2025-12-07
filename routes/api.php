<?php

use App\Http\Controllers\Api\V1\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ProfileController,
    UpdatePasswordController,
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
            Route::get('me', [ProfileController::class, 'show']);
            Route::match(['put', 'patch'], 'me', [ProfileController::class, 'update']);
            Route::match(['put', 'patch'], 'me/password', UpdatePasswordController::class);
            Route::match(['put', 'patch'], 'me/fcm-token', UpdateFcmTokenController::class);
            Route::delete('logout', LogoutController::class);
        });
    });
