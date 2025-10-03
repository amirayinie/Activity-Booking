<?php

use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('user/login', [AuthController::class, 'login']);
    Route::post('user/register', [AuthController::class, 'register']);

    Route::apiResource('activities',ActivityController::class);
    
    Route::middleware('auth:api')->group(function () {

        Route::post('user/logout', [AuthController::class, 'logout']);
    });
});
