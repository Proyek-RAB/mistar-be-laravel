<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\InfrastructureEditHistoryController;
use App\Http\Controllers\InfrastructureRequestController;
use App\Http\Controllers\InfrastructureTypeController;
use App\Http\Controllers\InfrastructureSubTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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
    Route::controller(InfrastructureController::class)->group(function (){
        Route::get('/search/infrastructures', 'searchInfrastructure')->name('infrastructure.search-all-infrastructure');
        Route::post('/infrastructures', 'index')->name('infrastructure.get-all-infrastructure');
        Route::get('/infrastructures/{id}', 'show')->name('infrastructure.get-all-infrastructure-byId');
        Route::get('/history', 'getInfrastructureHistory')->name('infrastructure.get-all-infrastructure-history');
        Route::get('/infrastructures/history/count', 'getSelfInfrastructureDashboardCount')->name('infrastructure.count-all-infrastructure-history');
        Route::post('/infrastructures/history/subtype/count', 'getSelfInfrastructureDashboardCountBySubTypeId')->name('infrastructure.count-all-infrastructure-history-subtype');
        Route::get('/infrastructures/detail/{id}', 'getDetail')->name('infrastructure.get-infrastructure-detail');
        Route::post('/infrastructures', 'store')->name('infrastructure.create-infrastructure');
        Route::patch('/infrastructures/{id}', 'update')->name('infrastructure.update-infrastructure');
        Route::put('/infrastructures/{id}/accept', 'approve')->name('infrastructure.approve');
        Route::put('/infrastructures/{id}/deny', 'deny')->name('infrastructure.deny');
        Route::put('/infrastructures/{id}/status', 'changeStatus')->name('infrastructure.changeStatus');

        Route::delete('/infrastructures/{id}', 'destroy')->name('infrastructure.delete-infrastructure');
    });

    Route::controller(InfrastructureRequestController::class)->group(function(){
        Route::get('/infrastructure/request', 'index')->name('infrastructurerequest.get-all-requested');
        Route::patch('/infrastructure/request/{id}', 'update')->name('infrastructurerequest.update-requested-infras');
    });


    Route::controller(InfrastructureTypeController::class)->group(function(){
        Route::get('infrastructuretype', 'index')->name('infrastructuretype.get-all-type');
    });

    Route::controller(InfrastructureSubTypeController::class)->group(function(){
        Route::get('infrastructuresubtype', 'index')->name('infrastructuresubtype.get-all-subtype');
    });

    Route::get('icons/{folder}/{filename}', [IconController::class, 'getIcon'])
        ->where(['folder' => '[A-Za-z0-9_\-]+', 'filename' => '[A-Za-z0-9_\-.]+']);
});
