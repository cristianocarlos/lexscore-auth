<?php

use App\Http\Controllers\WardAuthController;
use App\Http\Controllers\WardProfileController;
use App\Http\Controllers\WardRoleController;
use App\Http\Controllers\WardRouteController;
use App\Http\Controllers\WardUserController;
use App\Models\WardUser;
use Illuminate\Support\Facades\Route;

Route::prefix('ward')->group(function () {
    Route::post('/login', [WardAuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/refresh', [WardAuthController::class, 'refresh']);
    Route::middleware('auth:' . WardUser::AUTH_GUARD)->group(function () {
        Route::post('/logout', [WardAuthController::class, 'logout']);
        //
        Route::post('/role/create', [WardRoleController::class, 'create']);
        Route::delete('/role/delete/{model}', [WardRoleController::class, 'delete']);
        Route::get('/role/group-index', [WardRoleController::class, 'groupIndex']);
        Route::get('/role/user-index', [WardRoleController::class, 'userIndex']);
        Route::put('/role/update/{model}', [WardRoleController::class, 'update']);
        Route::get('/role/view/{model?}', [WardRoleController::class, 'view']);
        //
        Route::get('/route/user-rows/{userId}', [WardRouteController::class, 'userRows']);
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
