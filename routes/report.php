<?php
use App\Http\Controllers\Report\ActivityReportController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {

Route::get('/report/activity',[ActivityReportController::class,'activityReportShow'])->name('activity.report');

Route::get('/activity-report/data', [ActivityReportController::class, 'fetch'])
    ->name('activity.report.data');
           
});