<?php

use App\Http\Controllers\ward\AuthController as WardAuthController;
use App\Http\Controllers\ward\MenuController as WardMenuController;
use App\Http\Controllers\ward\ProfileController as WardProfileController;
use App\Http\Controllers\ward\RoleController as WardRoleController;
use App\Http\Controllers\ward\RouteController as WardRouteController;
use App\Http\Controllers\ward\UserController as WardUserController;
use App\Models\ward\User as WardUser;
use Illuminate\Support\Facades\Route;

Route::prefix('ward')->group(function () {
    Route::post('/login', [WardAuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/refresh', [WardAuthController::class, 'refresh']);
    Route::middleware('auth:' . WardUser::AUTH_GUARD)->group(function () {
        Route::post('/logout', [WardAuthController::class, 'logout']);
        //
        Route::post('/menu/create', [WardMenuController::class, 'create']);
        Route::delete('/menu/delete/{model}', [WardMenuController::class, 'delete']);
        Route::get('/menu/index', [WardMenuController::class, 'index']);
        Route::put('/menu/reorder', [WardMenuController::class, 'reorder']);
        Route::get('/menu/suggest', [WardMenuController::class, 'suggest']);
        Route::put('/menu/update/{model}', [WardMenuController::class, 'update']);
        Route::get('/menu/view/{model?}', [WardMenuController::class, 'view']);
        //
        Route::post('/role/create', [WardRoleController::class, 'create']);
        Route::delete('/role/delete/{model}', [WardRoleController::class, 'delete']);
        Route::get('/role/group-index', [WardRoleController::class, 'groupIndex']);
        Route::get('/role/group-role-rows/{roleId}', [WardRoleController::class, 'groupRoleRows']);
        Route::get('/role/user-index', [WardRoleController::class, 'userIndex']);
        Route::put('/role/update/{model}', [WardRoleController::class, 'update']);
        Route::get('/role/view/{model?}', [WardRoleController::class, 'view']);
        //
        Route::get('/route/role-rows/{roleId}', [WardRouteController::class, 'roleRows']);
        Route::get('/route/suggest', [WardRouteController::class, 'suggest']);
        //
        Route::post('/user/create', [WardUserController::class, 'create']);
        Route::delete('/user/delete/{model}', [WardUserController::class, 'delete']);
        Route::get('/user/index', [WardUserController::class, 'index']);
        Route::put('/user/update/{model}', [WardUserController::class, 'update']);
        Route::get('/user/view/{model?}', [WardUserController::class, 'view']);
        //
        Route::put('/profile/personal-info-update', [WardProfileController::class, 'personalInfoUpdate']);
        Route::put('/profile/preferences-update', [WardProfileController::class, 'preferencesUpdate']);
        Route::get('/profile/view', [WardProfileController::class, 'view']);
    });
});
