<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api-key')
    ->prefix('v1')
    ->group(function () {
        require __DIR__ . '/api-version/v1/auth.php';
    });
