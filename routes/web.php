<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\FuelPriceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;


Route::post('language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::group([
    'middleware' => 'locale',
], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // AJAX endpoint for fetching stations
    Route::get('/stations/find', [HomeController::class, 'findStations'])->name('stations.find');

    // Fuel Price Routes
    Route::post('/fuel-prices', [FuelPriceController::class, 'store'])->name('fuel_prices.store');
    Route::post('/fuel-prices/results', [FuelPriceController::class, 'fetchResults'])->name('fuel_prices.results');


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
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/userprofile', [UserController::class, 'showProfile'])->name('user.profile');
        Route::post('/userprofile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
        Route::post('/userprofile/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');

        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
        Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store');
        Route::post('/complaints/{complaint}/reply', [ComplaintController::class, 'reply'])->name('complaints.reply');
    });

    // Routes accessible only by Users
    Route::group(['middleware' => ['role:User']], function () {
        Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
        Route::post('/vehicle/store', [VehicleController::class, 'store'])->name('vehicle.store');

        Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    });

    // Routes accessible only by Station Managers
    Route::group(['middleware' => ['role:Station Manager']], function () {
        // View all stations managed by the station manager
        Route::get('/stations', [StationController::class, 'index'])->name('stations');
        // Show the form to create a new station
        Route::get('/stations/create', [StationController::class, 'create'])->name('stations.create');
        // Store a new station
        Route::post('/stations', [StationController::class, 'store'])->name('stations.store');

    });

});
