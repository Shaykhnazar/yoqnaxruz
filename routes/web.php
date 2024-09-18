<?php

use App\Http\Controllers\FuelPriceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

// Login Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Protected Route Example
// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/userprofile', [UserController::class, 'showProfile'])->name('user.profile');
    Route::post('/userprofile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('/userprofile/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');
});

// Routes accessible only by Users
Route::group(['middleware' => ['role:User']], function () {
    Route::get('/user/vehicles', [VehicleController::class, 'index'])->name('user.vehicles');
    // Other user routes...
});

// Routes accessible only by Station Managers
Route::group(['middleware' => ['role:Station Manager']], function () {
    Route::get('/station-manager/stations', [StationController::class, 'index'])->name('station-manager.stations');
    // Other station manager routes...
});

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/stations', [StationController::class, 'store'])->name('stations.store');
Route::post('/fuel-prices', [FuelPriceController::class, 'store'])->name('fuel_prices.store');
Route::post('/fuel-prices/results', [FuelPriceController::class, 'fetchResults'])->name('fuel_prices.results');
