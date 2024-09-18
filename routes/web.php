<?php

use App\Http\Controllers\FuelPriceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::post('/stations', [StationController::class, 'store'])->name('stations.store');
Route::post('/fuel-prices', [FuelPriceController::class, 'store'])->name('fuel_prices.store');
Route::post('/fuel-prices/results', [FuelPriceController::class, 'fetchResults'])->name('fuel_prices.results');
