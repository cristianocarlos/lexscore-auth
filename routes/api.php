<?php

use App\Http\Controllers\WardAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('ward')->group(function () {
    Route::post('/login', [WardAuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/refresh', [WardAuthController::class, 'refresh']);
    Route::post('/deactivate', [WardAuthController::class, 'deactivate']);
    Route::post('/reactivate', [WardAuthController::class, 'reactivate']);
    Route::middleware('auth:intranet')->group(function () {
        Route::post('/logout', [WardAuthController::class, 'logout']);
    });
});
