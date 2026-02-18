<?php

use App\Http\Controllers\Api\AIController;
use App\Http\Controllers\Api\TemplateApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\ServiceAppointmentController;
use App\Http\Controllers\CustomerDocumentController;
use App\Http\Controllers\DriverLicenseController;

/*
|--------------------------------------------------------------------------
| Driver License Routes
|--------------------------------------------------------------------------
|
| Add these routes to your web.php or api.php file
|
*/

// Driver License Scanner Routes



Route::prefix('customers/{customer}')->group(function () {
    Route::get('documents', [CustomerDocumentController::class, 'getCustomerDocuments']); // fetch documents
    Route::post('documents', [CustomerDocumentController::class, 'store']); // upload
});

Route::delete('documents/{document}', [CustomerDocumentController::class, 'destroy']); // delete
Route::get('documents/{document}/download', [CustomerDocumentController::class, 'download']); // download

Route::put('deals/{deal}', [DealController::class, 'update']);


Route::get('/deals/{deal}/vehicle-partial', [DealController::class, 'vehiclePartial']);
Route::get('/deals/{deal}/service-history-partial', [ServiceAppointmentController::class, 'serviceHistoryPartial']);
Route::post('/service-appointment/create', [ServiceAppointmentController::class, 'store']);

Route::middleware(['web'])->group(function () {
    // AI Generation Routes
    Route::post('/ai/generate-email', [AIController::class, 'generateEmail']);
    Route::post('/ai/generate-subjects', [AIController::class, 'generateSubjects']);
    Route::post('/ai/generate-image', [AIController::class, 'generateImage']);
    
    // Template API Routes (optional)
    Route::post('templates/{template}/preview', [TemplateApiController::class, 'preview']);
    Route::post('templates/{template}/toggle-status', [TemplateApiController::class, 'toggleStatus']);
    Route::get('templates/merge-fields', [TemplateApiController::class, 'mergeFields']);
});



/*
|--------------------------------------------------------------------------
| API Routes for Deals Management
|--------------------------------------------------------------------------
*/
 Route::post('/deals/{deal}/payment', [PaymentController::class, 'store'])
        ->name('deals.payment.store');
    
    // Get payment details for a deal
    // GET /api/deals/{deal}/payment
    Route::get('/deals/{deal}/payment', [PaymentController::class, 'show'])
        ->name('deals.payment.show');
    
    // Delete payment for a deal
    // DELETE /api/deals/{deal}/payment
    Route::delete('/deals/{deal}/payment', [PaymentController::class, 'destroy'])
        ->name('deals.payment.destroy');

     Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::get('/search', [InventoryController::class, 'search']);
        Route::get('/makes', [InventoryController::class, 'getMakes']);
        Route::get('/models', [InventoryController::class, 'getModels']);
        Route::get('/{inventory}', [InventoryController::class, 'show']);
    });

// Simple templates list for campaign modal (returns active templates)
Route::get('/templates', function () {
    return \App\Models\Template::all();
});

// Return senders (teams and individuals) for campaign modal
Route::get('/senders', function () {
    $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();
    $users = \App\Models\User::where('is_active', true)->orderBy('name')->get();

    $teams = $roles->map(function($r) {
        $members = \App\Models\User::whereHas('roles', function($q) use ($r){ $q->where('id', $r->id); })->where('is_active', true)->orderBy('name')->get();
        return [
            'id' => $r->id,
            'name' => $r->name,
            'label' => $r->name,
            'members' => $members->map(function($m){ return ['id' => $m->id, 'name' => $m->name, 'email' => $m->email]; })->toArray()
        ];
    });

    $individuals = $users->map(function($u){ return ['id' => $u->id, 'name' => $u->name, 'email' => $u->email]; });

    return response()->json(['teams' => $teams, 'individuals' => $individuals]);
});

// Languages
Route::get('/languages', function () {
    $langs = config('app.locales') ?? ['en' => 'English', 'fr' => 'French'];
    $arr = [];
    foreach ($langs as $k => $v) {
        $arr[] = ['code' => $k, 'label' => is_string($v) ? $v : $k];
    }
    return response()->json($arr);
});

    // ==================== USERS ====================
    Route::get('/users', [UserController::class, 'usersList']);

    // ==================== DEALS ====================
    Route::prefix('deals')->group(function () {
        Route::get('/', [DealController::class, 'index']);
        Route::post('/', [DealController::class, 'store']);
        Route::get('/{deal}', [DealController::class, 'show']);
        Route::put('/{deal}', [DealController::class, 'update']);
        Route::patch('/{deal}', [DealController::class, 'update']);
        Route::delete('/{deal}', [DealController::class, 'destroy']);
        
        // Deal specific endpoints
        Route::get('/{deal}/vehicle', [DealController::class, 'getVehicle']);
        Route::get('/{deal}/activities', [DealController::class, 'getActivities']);
        Route::patch('/{deal}/field', [DealController::class, 'updateField']);
    });

    // Customer deals
    Route::get('/customers/{customerId}/deals', [DealController::class, 'getCustomerDeals']);

    // Campaigns
    Route::prefix('campaigns')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\CampaignController::class, 'index']);
        Route::get('/{campaign}/recipients', [App\Http\Controllers\Api\CampaignController::class, 'recipients']);
        Route::post('/', [App\Http\Controllers\Api\CampaignController::class, 'store']);
        Route::get('/{campaign}', [App\Http\Controllers\Api\CampaignController::class, 'show']);
        Route::put('/{campaign}', [App\Http\Controllers\Api\CampaignController::class, 'update']);
        Route::delete('/{campaign}', [App\Http\Controllers\Api\CampaignController::class, 'destroy']);
    });

    // ==================== TASKS ====================
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'taskFetchByAjax']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/{task}', [TaskController::class, 'edit']);
        Route::put('/{task}', [TaskController::class, 'update']);
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus']);
        Route::delete('/{task}', [TaskController::class, 'destroy']);
        
        // Calendar view
        Route::get('/calendar/events', [TaskController::class, 'calendarTasks']);
    });

    // ==================== NOTES ====================
    Route::prefix('notes')->group(function () {
        Route::get('/', [NoteController::class, 'index']);
        Route::post('/', [NoteController::class, 'store']);
        Route::put('/{note}', [NoteController::class, 'update']);
        Route::delete('/{note}', [NoteController::class, 'destroy']);
        
        // History
        Route::get('/history', [NoteController::class, 'getHistory']);
    });

    // ==================== SHOWROOM VISITS ====================
    Route::prefix('visits')->group(function () {
        Route::get('/latest', [NoteController::class, 'latestVisit']);
        Route::get('/{visit}', [NoteController::class, 'showVisit']);
        Route::post('/start', [NoteController::class, 'startVisit']);
        Route::post('/{visit}/stop', [NoteController::class, 'stopVisit']);
        Route::put('/{visit}', [NoteController::class, 'updateVisit']);
    });

    // ==================== INVENTORY ====================
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::get('/search', [InventoryController::class, 'search']);
        Route::get('/{inventory}', [InventoryController::class, 'show']);
    });

