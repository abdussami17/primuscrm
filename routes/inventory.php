<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory Routes
|--------------------------------------------------------------------------
*/

// Main inventory page (server-side rendered)
Route::get('/inventory', [InventoryController::class, 'inventoryListing'])->name('inventory.web');

// Form submissions
Route::patch('/inventory/price', [InventoryController::class, 'updatePrice'])->name('inventory.update-price');
Route::patch('/inventory/images', [InventoryController::class, 'updateImages'])->name('inventory.update-images');
Route::post('/inventory/brochure', [InventoryController::class, 'sendBrochure'])->name('inventory.send-brochure');

// API routes for modal data
Route::prefix('api/inventory')->group(function () {
    Route::get('/{inventory}/availability', [InventoryController::class, 'getAvailability']);
    Route::get('/{inventory}/price', [InventoryController::class, 'getPriceDetails']);
    Route::get('/{inventory}/images', [InventoryController::class, 'getImages']);
    Route::get('/{inventory}/book-value', [InventoryController::class, 'getBookValue']);
});

// User preferences API
Route::post('/api/user/preferences', function (\Illuminate\Http\Request $request) {
    if ($request->has('show_image_count')) {
        session(['show_image_count' => $request->boolean('show_image_count')]);
    }
    return response()->json(['success' => true]);
})->name('user.preferences');