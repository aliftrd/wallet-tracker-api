<?php


use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('api-key')
    ->prefix('v1')
    ->group(function () {
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
    });
