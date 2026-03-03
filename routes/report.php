<?php
use App\Http\Controllers\Report\ActivityReportController;
<<<<<<< HEAD
use App\Http\Controllers\Report\EmailReportController;
=======
>>>>>>> 2c2262bd2e44b91ac79d76b1f44bd9e5dba4bdb6
use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {

Route::get('/report/activity',[ActivityReportController::class,'activityReportShow'])->name('activity.report');

Route::get('/activity-report/data', [ActivityReportController::class, 'fetch'])
    ->name('activity.report.data');
<<<<<<< HEAD
    Route::get('activity/export', [ActivityReportController::class,'export'])
->name('activity.report.export');



Route::get('/report/email',[EmailReportController::class,'emailReportShow'])->name('email.report');


           
});
=======
           
});
Route::get('activity/export', [ActivityReportController::class,'export'])
->name('activity.report.export');
>>>>>>> 2c2262bd2e44b91ac79d76b1f44bd9e5dba4bdb6
