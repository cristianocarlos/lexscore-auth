<?php

use App\Http\Controllers\WardAuthController;
use App\Http\Controllers\WardProfileController;
use App\Http\Controllers\WardUserController;
use App\Models\WardUser;
use Illuminate\Support\Facades\Route;

Route::prefix('ward')->group(function () {
    Route::post('/login', [WardAuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/refresh', [WardAuthController::class, 'refresh']);
    Route::middleware('auth:' . WardUser::AUTH_GUARD)->group(function () {
        Route::post('/logout', [WardAuthController::class, 'logout']);
        //
        Route::post('/user/create', [WardUserController::class, 'create']);
        Route::delete('/user/delete/{model}', [WardUserController::class, 'delete']);
        Route::get('/user/index', [WardUserController::class, 'index']);
        Route::put('/user/update/{model}', [WardUserController::class, 'update']);
        Route::get('/user/view/{model?}', [WardUserController::class, 'view']);
        //
        Route::put('/profile/update', [WardProfileController::class, 'update']);
        Route::get('/profile/view', [WardProfileController::class, 'view']);
    });
});
