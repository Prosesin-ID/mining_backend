<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\BiayaRuteController;
use App\Http\Controllers\UnitTruckController;
use App\Http\Controllers\CheckPointController;
use App\Http\Controllers\DriverMoneyController;
use App\Http\Controllers\DriverRequestController;
use App\Http\Controllers\DriverLogActivityController;
use App\Http\Controllers\Api\LocationTrackingController;

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthUserController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

Route::middleware(['validate.user'])->group(function () {

    Route::get('/home', [AuthUserController::class, 'home'])->name('home');
    Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');

    Route::resource('checkpoints', CheckPointController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('unit_trucks', UnitTruckController::class);

    Route::get('/driver_money', [DriverMoneyController::class, 'index'])->name('driver_money.index');
    Route::put('/driver_money/topup/{driverId}', [DriverMoneyController::class, 'topUp'])->name('driver_money.topup');

    Route::get('/driver_requests', [DriverRequestController::class, 'index'])->name('driver_requests.index');
    Route::put('/driver_requests/approve/{id}', [DriverRequestController::class, 'approve'])->name('driver_requests.approve');
    Route::put('/driver_requests/reject/{id}', [DriverRequestController::class, 'reject'])->name('driver_requests.reject');

    Route::resource('biaya_rute', BiayaRuteController::class);

    Route::get('/driver_log_activities', [DriverLogActivityController::class, 'index'])->name('driver_log_activities.index');
    Route::post('/driver_log_activities/filter_by_date', [DriverLogActivityController::class, 'fliterByDate'])->name('driver_log_activities.filter');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    
    // Location tracking for map
    Route::get('/api/location/active', [LocationTrackingController::class, 'getActiveLocations'])->name('location.active');

});
