<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SmartSequenceController;

Route::middleware(['auth'])->group(function () {


	Route::prefix('smart-sequences')->name('smart-sequences.')->group(function () {
        
        // Main CRUD
        Route::get('/', [SmartSequenceController::class, 'index'])->name('index');
        Route::get('/create', [SmartSequenceController::class, 'create'])->name('create');
        Route::post('/', [SmartSequenceController::class, 'store'])->name('store');
        Route::get('/{smartSequence}', [SmartSequenceController::class, 'show'])->name('show');
        Route::get('/{smartSequence}/edit', [SmartSequenceController::class, 'edit'])->name('edit');
        Route::put('/{smartSequence}', [SmartSequenceController::class, 'update'])->name('update');
        Route::delete('/{smartSequence}', [SmartSequenceController::class, 'destroy'])->name('destroy');
        
        // Additional actions
        Route::post('/{smartSequence}/toggle-status', [SmartSequenceController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{smartSequence}/duplicate', [SmartSequenceController::class, 'duplicate'])->name('duplicate');
        Route::post('/{smartSequence}/validate-actions', [SmartSequenceController::class, 'validateActions'])->name('validate-actions');
        
        // Configuration endpoints
        Route::get('/config/fields', [SmartSequenceController::class, 'getFieldConfig'])->name('config.fields');
        Route::get('/config/actions', [SmartSequenceController::class, 'getActionConfig'])->name('config.actions');
        Route::get('/config/field-operators', [SmartSequenceController::class, 'getFieldOperators'])->name('config.field-operators');
        
        // Export
        Route::get('/export/download', [SmartSequenceController::class, 'export'])->name('export');
        // Bulk delete selected sequences
        Route::post('/bulk-delete', [SmartSequenceController::class, 'bulkDestroy'])->name('bulk-delete');
    });


    // Email routes
    Route::prefix('email')->name('email.')->group(function () {
        // Main folders
        Route::get('/', [EmailController::class, 'inbox'])->name('inbox');
        Route::get('/starred', [EmailController::class, 'starred'])->name('starred');
        Route::get('/sent', [EmailController::class, 'sent'])->name('sent');
        Route::get('/drafts', [EmailController::class, 'drafts'])->name('drafts');
        Route::get('/deleted', [EmailController::class, 'deleted'])->name('deleted');

        // Compose/Send
        Route::post('/send', [EmailController::class, 'store'])->name('send');

        // Single email actions
        Route::get('/sidebar-counts', [EmailController::class, 'liveEmailCounts'])->name('email.counts');
        Route::get('/{email}', [EmailController::class, 'show'])->name('reply');
        Route::post('/{email}/star', [EmailController::class, 'toggleStar'])->name('star');
        Route::post('/{email}/read', [EmailController::class, 'toggleRead'])->name('read');
        Route::delete('/{email}', [EmailController::class, 'destroy'])->name('delete');

        // Deleted email actions
        Route::post('/restore/{id}', [EmailController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [EmailController::class, 'forceDelete'])->name('force-delete');

        // Bulk actions
        Route::post('/bulk-delete', [EmailController::class, 'bulkDelete'])->name('bulk-delete');

        // Utilities
        Route::get('/search/users', [EmailController::class, 'searchUsers'])->name('search-users');
        Route::get('/template/{template}', [EmailController::class, 'getTemplate'])->name('template');
        Route::get('/attachment/{attachment}/download', [EmailController::class, 'downloadAttachment'])->name('download-attachment');
    });
});