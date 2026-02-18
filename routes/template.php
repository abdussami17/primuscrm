<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\PhoneTemplateController;


Route::middleware(['auth'])->group(function () {
 Route::resource('mobile-templates', PhoneTemplateController::class);
    // DataTables server-side data endpoint must be registered before the resource
    // so the literal 'data' path isn't captured by the {template} parameter.
    Route::get('templates/data', [TemplateController::class, 'data'])
        ->name('templates.data');

    Route::resource('templates',TemplateController::class);
             Route::post('templates/{template}/duplicate', [TemplateController::class, 'duplicate'])
        ->name('templates.duplicate');
    
    Route::post('templates/delete-multiple', [TemplateController::class, 'destroyMultiple'])
        ->name('templates.destroy-multiple');
    
    Route::get('templates/{template}/preview', [TemplateController::class, 'preview'])
        ->name('templates.preview');


       
});