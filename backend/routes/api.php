<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        
        // Live Classes API
        Route::get('/live-classes', [\App\Http\Controllers\Api\LiveClassApiController::class, 'getActiveClasses']);
        
        // Future routes will be added here
        // e.g., /courses, /videos/{id}/play, /device/register
    });
});
