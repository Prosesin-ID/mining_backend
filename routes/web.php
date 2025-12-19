<?php

use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthUserController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/home', 'home')->name('home');
    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('checkpoints', App\Http\Controllers\CheckPointController::class);
Route::resource('drivers', App\Http\Controllers\DriverController::class);
Route::resource('unit_trucks', App\Http\Controllers\UnitTruckController::class);

Route::get('/driver_money', [App\Http\Controllers\DriverMoneyController::class, 'index'])->name('driver_money.index');
Route::put('/driver_money/topup/{driverId}', [App\Http\Controllers\DriverMoneyController::class, 'topUp'])->name('driver_money.topup');
Route::get('/driver_requests', [App\Http\Controllers\DriverRequestController::class, 'index'])->name('driver_requests.index');
Route::put('/driver_requests/approve/{id}', [App\Http\Controllers\DriverRequestController::class, 'approve'])->name('driver_requests.approve');
Route::put('/driver_requests/reject/{id}', [App\Http\Controllers\DriverRequestController::class, 'reject'])->name('driver_requests.reject');

Route::resource('biaya_rute', App\Http\Controllers\BiayaRuteController::class);

Route::get('/driver_log_activities', [App\Http\Controllers\DriverLogActivityController::class, 'index'])->name('driver_log_activities.index');
Route::post('/driver_log_activities/filter_by_date', [App\Http\Controllers\DriverLogActivityController::class, 'fliterByDate'])->name('driver_log_activities.filter');

Route::get('/report', function() {
    return view('report.index');
});