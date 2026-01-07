<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverAuthController;

// Public routes (tidak perlu authentication)
Route::prefix('driver')->group(function () {
    Route::post('/login', [DriverAuthController::class, 'login']);
});

// Protected routes (perlu authentication token)
Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('/profile', [DriverAuthController::class, 'profile']);
    Route::post('/logout', [DriverAuthController::class, 'logout']);
});