<?php

use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('user/login', [AuthController::class, 'login']);
    Route::post('user/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {

        Route::apiResource('activities', ActivityController::class);
        Route::post('booking', [BookingController::class, 'createBooking']);
        Route::post('booking/cancel', [BookingController::class, 'cancelBooking']);

        Route::post('user/logout', [AuthController::class, 'logout']);
    });
});
