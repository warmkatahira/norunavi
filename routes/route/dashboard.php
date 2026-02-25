<?php

use Illuminate\Support\Facades\Route;

// +-+-+-+-+-+-+-+- ダッシュボード +-+-+-+-+-+-+-+-
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AjaxController;
use App\Http\Controllers\Dashboard\RideScheduleSelectUpdateController;
use App\Http\Controllers\Dashboard\RideDriverCandidateCreateController;
use App\Http\Controllers\Dashboard\RideDriverCandidateDeleteController;

Route::middleware('common')->group(function (){
    // -+-+-+-+-+-+-+-+-+-+-+-+ ダッシュボード -+-+-+-+-+-+-+-+-+-+-+-+
    Route::controller(DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function(){
        Route::get('', 'index')->name('index');
    });
    Route::controller(AjaxController::class)->prefix('ajax')->name('ajax.')->group(function(){
        Route::get('get_ride_schedule_select_info', 'get_ride_schedule_select_info');
    });
    Route::controller(RideScheduleSelectUpdateController::class)->prefix('ride_schedule_select_update')->name('ride_schedule_select_update.')->group(function(){
        Route::post('update', 'update')->name('update');
    });
    Route::controller(RideDriverCandidateCreateController::class)->prefix('ride_driver_candidate_create')->name('ride_driver_candidate_create.')->group(function(){
        Route::post('create', 'create');
    });
    Route::controller(RideDriverCandidateDeleteController::class)->prefix('ride_driver_candidate_delete')->name('ride_driver_candidate_delete.')->group(function(){
        Route::post('delete', 'delete');
    });
});