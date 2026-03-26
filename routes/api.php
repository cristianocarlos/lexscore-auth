<?php

use App\Http\Controllers\ward;
use App\Models\ward\AuthUser as WardAuthUser;
use Illuminate\Support\Facades\Route;

Route::prefix('ward')->group(function () {
    Route::post('/login', [ward\AuthenticationController::class, 'login'])->middleware('throttle:6,1');
    Route::post('/refresh', [ward\AuthenticationController::class, 'refresh']);
    Route::patch('/user-email-change/confirm/{token}', [ward\AuthUserEmailChangeController::class, 'confirm']);
    Route::patch('/user-password-reset/ask', [ward\AuthUserPasswordResetController::class, 'ask'])->middleware('throttle:1,1');
    Route::patch('/user-password-reset/confirm/{token}', [ward\AuthUserPasswordResetController::class, 'confirm']);
    Route::middleware('auth:' . WardAuthUser::GUARD)->group(function () {
        Route::post('/logout', [ward\AuthenticationController::class, 'logout']);
        //
        Route::post('/menu/create', [ward\MenuController::class, 'create']);
        Route::delete('/menu/delete/{model}', [ward\MenuController::class, 'delete']);
        Route::get('/menu/index', [ward\MenuController::class, 'index']);
        Route::put('/menu/reorder', [ward\MenuController::class, 'reorder']);
        Route::get('/menu/suggest', [ward\MenuController::class, 'suggest']);
        Route::put('/menu/update/{model}', [ward\MenuController::class, 'update']);
        Route::get('/menu/view/{model?}', [ward\MenuController::class, 'view']);
        //
        Route::patch('/profile/password-update', [ward\ProfileController::class, 'passwordUpdate']);
        Route::put('/profile/personal-info-update', [ward\ProfileController::class, 'personalInfoUpdate']);
        Route::get('/profile/preferences-load/{model}', [ward\ProfileController::class, 'preferencesLoad']);
        Route::patch('/profile/preferences-update', [ward\ProfileController::class, 'preferencesUpdate']);
        Route::get('/profile/view', [ward\ProfileController::class, 'view']);
        //
        Route::post('/role/create', [ward\RoleController::class, 'create']);
        Route::delete('/role/delete/{model}', [ward\RoleController::class, 'delete']);
        Route::get('/role/group-index', [ward\RoleController::class, 'groupIndex']);
        Route::get('/role/group-role-rows/{roleId}', [ward\RoleController::class, 'groupRoleRows']);
        Route::get('/role/user-index', [ward\RoleController::class, 'userIndex']);
        Route::put('/role/update/{model}', [ward\RoleController::class, 'update']);
        Route::get('/role/view/{model?}', [ward\RoleController::class, 'view']);
        //
        Route::get('/route/role-rows/{roleId}', [ward\RouteController::class, 'roleRows']);
        Route::get('/route/suggest', [ward\RouteController::class, 'suggest']);
        //
        Route::post('/user/create', [ward\CrudUserController::class, 'create']);
        Route::delete('/user/delete/{model}', [ward\CrudUserController::class, 'delete']);
        Route::get('/user/index', [ward\CrudUserController::class, 'index']);
        Route::get('/user/photo-load/{model}', [ward\CrudUserController::class, 'photoLoad']);
        Route::put('/user/update/{model}', [ward\CrudUserController::class, 'update']);
        Route::get('/user/view/{model?}', [ward\CrudUserController::class, 'view']);
        //
        Route::patch('/user-email-change/ask', [ward\AuthUserEmailChangeController::class, 'ask'])->middleware('throttle:1,1');
    });
});
