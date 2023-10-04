<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('auth.register');
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/forgot-password', 'forgotPassword')->name('auth.forgot-password');
    Route::post('/forgot-password/otp', 'forgotPasswordOtpValidation')->name('auth.forgot-password-otp');
    Route::post('/change-password', 'changePassword')->name('auth.change-password');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard.get-summary-report');
        Route::get('/dashboard/point', 'point')->name('dashboard.get-point-report');
        Route::get('/dashboard/line', 'line')->name('dashboard.get-line-report');
        Route::get('/dashboard/area', 'area')->name('dashboard.get-area-report');
        Route::get('/dashboard/user', 'user')->name('dashboard.get-user-report');
    });
});
