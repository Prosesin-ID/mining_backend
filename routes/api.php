<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverAuthController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\RequestSaldoController;
use App\Http\Controllers\Api\CheckInApiController;
use App\Http\Controllers\Api\CheckOutApiController;
use App\Http\Controllers\Api\LocationTrackingController;
use App\Http\Controllers\AuthUserController;

// Public routes (tidak perlu authentication)
Route::prefix('driver')->group(function () {
    Route::post('/login', [DriverAuthController::class, 'login']);
});

// Public checkpoint locations for admin map (session-based auth handled on web side)
Route::get('/checkpoints/locations', [AuthUserController::class, 'getCheckpointLocations']);

// Protected routes (perlu authentication token)
Route::middleware('auth:sanctum')->prefix('driver')->group(function () {
    Route::get('/profile', [DriverAuthController::class, 'profile']);
    Route::post('/logout', [DriverAuthController::class, 'logout']);
    
    // Home routes
    Route::get('/home', [HomeApiController::class, 'index']);
    Route::get('/home/history', [HomeApiController::class, 'todayHistory']);
    Route::post('/home/nearby-checkpoints', [HomeApiController::class, 'nearbyCheckpoints']);
    Route::post('/home/status/on', [HomeApiController::class, 'turnOnStatus']);
    Route::post('/home/status/off', [HomeApiController::class, 'turnOffStatus']);
    Route::post('/home/status/end-maintenance', [HomeApiController::class, 'endMaintenance']);
    
    // Request Saldo routes
    Route::post('/request-saldo/top-up', [RequestSaldoController::class, 'topUp']);
    Route::get('/request-saldo/my-requests', [RequestSaldoController::class, 'myRequests']);
    
    // Check-in routes
    Route::post('/check-in', [CheckInApiController::class, 'checkIn']);
    Route::get('/check-in/status', [CheckInApiController::class, 'getCurrentStatus']);
    
    // Checkout routes
    Route::get('/checkout/active-checkin', [CheckOutApiController::class, 'getActiveCheckIn']);
    Route::post('/checkout/checkpoints', [CheckOutApiController::class, 'getCheckoutCheckpoints']);
    Route::post('/checkout/request', [CheckOutApiController::class, 'requestCheckout']);
    Route::get('/checkout/status', [CheckOutApiController::class, 'getCheckoutStatus']);
    
    // Location tracking routes
    Route::post('/location/update', [LocationTrackingController::class, 'updateLocation']);
    Route::get('/location/active', [LocationTrackingController::class, 'getActiveLocations']);
    
});