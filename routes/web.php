<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TradeInController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerNoteController;
use App\Http\Controllers\DriverLicenseController;
use App\Http\Controllers\ManagerDeskLogController;
use App\Http\Controllers\EmployeeDeskLogController;
use App\Http\Controllers\DealershipInfoController;
use App\Http\Controllers\IpRestrictionController;
use App\Http\Controllers\StoreHoursController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\MergeSoldDealsController;
use App\Http\Controllers\EmailAccountController;
use App\Http\Controllers\TelnyxController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|-----
---------------------------------------------------------------------
*/



Route::prefix('driver-license')->name('driver-license.')->middleware(['auth'])->group(function () {
    Route::post('/upload', [DriverLicenseController::class, 'upload'])->name('upload');
    Route::delete('/delete', [DriverLicenseController::class, 'delete'])->name('delete');
});
Route::prefix('customers')->group(function () {
    Route::get('{customer}/notes', [CustomerNoteController::class, 'index']);
    Route::post('notes', [CustomerNoteController::class, 'store']);
});



Route::prefix('customers')->name('customers.')->group(function () {

    // Import customers (Excel / CSV)
    Route::post('/import', [CustomerController::class, 'importCustomers'])
        ->name('import');

    // Download sample Excel template
    Route::get('/import/sample', [CustomerController::class, 'sample'])
        ->name('import.sample');

});



Auth::routes();


Route::resource('trade-ins',TradeInController::class);

Route::get('/cache', function () {
    \Artisan::call('route:cache');
    \Artisan::call('config:cache');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('optimize:clear');
    return 'Application optimized';
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {

   // TASK ROUTES
Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/all', [TaskController::class, 'taskFetchByAjax'])->name('all');
    Route::delete('/delete/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('edit');
    Route::put('/update/{task}', [TaskController::class, 'update'])->name('update');
});



/*
|--------------------------------------------------------------------------
| Email Routes
|--------------------------------------------------------------------------
*/


Route::prefix('notes')
        ->name('notes.')
        ->group(function () {
            Route::post('/store', [NoteController::class, 'store'])->name('save');
            Route::get('/tasks/{task}', [NoteController::class, 'fetch']);
        });

// Task-specific notes (task_notes table)
Route::get('/task-notes/tasks/{task}', [NoteController::class, 'fetchTaskNotes']);
Route::post('/task-notes/tasks/{task}', [NoteController::class, 'storeTaskNotes']);



// Reports routes (list + view). Use ReportController to render report blades.
Route::middleware(['auth', 'permission:Access Reports & Analytics'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{key}', [ReportController::class, 'show'])->name('reports.show');
        });

    // CUSTOMER ROUTES


    Route::middleware('permission:Edit All Dealer Deals/Customer Info')
        ->prefix('customers')
        ->group(function () {
            Route::post('/merge', [CustomerController::class, 'merge'])->name('customers.merge');
            Route::post('/{id}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
        });

    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('permission:Delete Customer')
        ->name('customers.destroy');

    Route::post('/customers/bulk-delete', [CustomerController::class, 'bulkDestroy'])
        ->middleware('permission:Delete Customer')
        ->name('customers.bulk-destroy');
});



/*
|--------------------------------------------------------------------------
| Protected Routes (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Telnyx integration endpoints (click-to-call / send-sms)
    Route::post('/telnyx/sms', [TelnyxController::class, 'sendSms'])->name('telnyx.sms');
    Route::post('/telnyx/call', [TelnyxController::class, 'makeCall'])->name('telnyx.call');
    Route::post('/telnyx/video', [TelnyxController::class, 'makeVideoCall'])->name('telnyx.video');
    Route::get('/telnyx/message/{id}', [TelnyxController::class, 'getMessage'])->name('telnyx.message');
    Route::get('/telnyx/messages', [TelnyxController::class, 'listMessages'])->name('telnyx.messages');
    // Webhook receiver - do NOT require auth; Telnyx will post here
    Route::post('/telnyx/webhook', [TelnyxController::class, 'webhook'])->withoutMiddleware(['auth'])->name('telnyx.webhook');

    /*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
    Route::view('/', 'dashboard')->name('dashboard');

    /*
|--------------------------------------------------------------------------
| Inbox Routes
|--------------------------------------------------------------------------
*/


    Route::get('/text-inbox', function () {
        return view('text-inbox');
    })->name('text.inbox')
        ->middleware('permission:Send Text');

    /*
|--------------------------------------------------------------------------
| Reply Routes
|--------------------------------------------------------------------------
*/


    Route::get('/text-reply', function () {
        return view('text-reply');
    })->name('text.reply');

    /*
|--------------------------------------------------------------------------
| AI & Task Routes
|--------------------------------------------------------------------------
*/
    Route::get('/primus-ai', function () {
        return view('primus-ai');
    })->name('primus.ai');

    /*
|--------------------------------------------------------------------------
| Customer & Inventory Routes
|--------------------------------------------------------------------------
*/

Route::prefix('desk-log')->name('desk-log.')->middleware(['auth'])->group(function () {
    Route::get('/manager', [ManagerDeskLogController::class, 'managerDeskLog'])->name('manager');
    Route::post('/update-date', [ManagerDeskLogController::class, 'updateDate'])->name('update-date');
    Route::post('/add-note', [ManagerDeskLogController::class, 'addNote'])->name('add-note');
    Route::get('/export', [ManagerDeskLogController::class, 'export'])->name('export');
});

Route::prefix('employee/desk-log')->name('employee-desk-log.')->middleware(['auth'])->group(function () {
    Route::get('/', [EmployeeDeskLogController::class, 'employeeDeskLog'])->name('employee');
    Route::post('/update-date', [EmployeeDeskLogController::class, 'updateDate'])->name('update-date');
    Route::post('/add-note', [EmployeeDeskLogController::class, 'addNote'])->name('add-note');
    Route::get('/export', [EmployeeDeskLogController::class, 'export'])->name('export');
});




    // Inventory API Routes
    Route::get('/api/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');

    Route::get('/api/inventory/available', [App\Http\Controllers\InventoryController::class, 'getAvailable'])->name('inventory.available');

    Route::get('/api/inventory/{inventory}', [App\Http\Controllers\InventoryController::class, 'show'])->name('inventory.show');

    Route::post('/api/inventory', [App\Http\Controllers\InventoryController::class, 'store'])
        ->name('inventory.store')
        ->middleware('permission:Edit All Dealer Deals/Customer Info');

    Route::put('/api/inventory/{inventory}', [App\Http\Controllers\InventoryController::class, 'update'])
        ->name('inventory.update')
        ->middleware('permission:Edit All Dealer Deals/Customer Info');

    Route::delete('/api/inventory/{inventory}', [App\Http\Controllers\InventoryController::class, 'destroy'])
        ->name('inventory.destroy')
        ->middleware('permission:Delete Customer');

    Route::get('/showroom', function () {
        return view('showroom');
    })
        ->name('showroom')
        ->middleware('permission:Access To Showroom');

    /*
|--------------------------------------------------------------------------
| Template & Campaign Routes
|--------------------------------------------------------------------------
*/



    Route::get('/smart-sequence', function () {
        return view('smart-sequence');
    })
        ->name('smart-sequence')
        ->middleware('permission:Access To Smart Sequences');

    Route::get('/campaigns', function () {
        $campaigns = \App\Models\Campaign::latest()->paginate(20);
        return view('campaigns', compact('campaigns'));
    })
        ->name('campaigns')
        ->middleware('permission:Access To Campaigns');

    /*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
    Route::middleware('permission:Access To Users')->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');

        Route::get('/add-user', [App\Http\Controllers\UserController::class, 'create'])->name('add-user');

        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');

        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/users/bulk-delete', [App\Http\Controllers\UserController::class, 'bulkDelete'])->name('users.bulk-delete');

        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');

        Route::post('/users/{user}/reactivate', [App\Http\Controllers\UserController::class, 'reactivate'])->name('users.reactivate');

        Route::post('/users/{user}/send-password-reset', [App\Http\Controllers\UserController::class, 'sendPasswordReset'])->name('users.send-password-reset');

        Route::get('/users/export/excel', [App\Http\Controllers\UserController::class, 'exportExcel'])->name('users.export.excel');

        Route::get('/users/export/pdf', [App\Http\Controllers\UserController::class, 'exportPdf'])->name('users.export.pdf');
    });

    // Users can edit themselves without special permission
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');

    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');


    // Deal Routes
    Route::get('/customers/{customer}/deals', [App\Http\Controllers\DealController::class, 'getCustomerDeals'])
        ->name('deals.customer')
        ->middleware('permission:View All Dealer Deals/Customer Info');#addCustomerCanvas

    // Global customer canvas (render fragment used by the common offcanvas)
    Route::get('/customers/{customer}/canvas', [App\Http\Controllers\CustomerController::class, 'edit'])
        ->name('customers.canvas')
        ->middleware('auth');

    Route::post('/deals', [App\Http\Controllers\DealController::class, 'store'])
        ->name('deals.store')
        ->middleware('permission:Edit All Dealer Deals/Customer Info');

    Route::put('/deals/{deal}', [App\Http\Controllers\DealController::class, 'update'])
        ->name('deals.update')
        ->middleware('permission:Edit All Dealer Deals/Customer Info');

    Route::delete('/deals/{deal}', [App\Http\Controllers\DealController::class, 'destroy'])
        ->name('deals.destroy')
        ->middleware('permission:Delete Customer');

    // Customer Documents Routes
    Route::get('/customers/{customer}/documents', [App\Http\Controllers\CustomerDocumentController::class, 'getCustomerDocuments'])
        ->name('documents.customer')
        ->middleware('permission:View All Dealer Deals/Customer Info');

    Route::post('/documents', [App\Http\Controllers\CustomerDocumentController::class, 'store'])
        ->name('documents.store')
        ->middleware('permission:Edit All Dealer Deals/Customer Info');

    Route::delete('/documents/{document}', [App\Http\Controllers\CustomerDocumentController::class, 'destroy'])
        ->name('documents.destroy')
        ->middleware('permission:Delete Customer');

    Route::get('/documents/{document}/download', [App\Http\Controllers\CustomerDocumentController::class, 'download'])
        ->name('documents.download')
        ->middleware('permission:View All Dealer Deals/Customer Info');

    /*
|--------------------------------------------------------------------------
| Calendar & Wishlist Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::put('/tasks/{task}', [CalendarController::class, 'update'])->name('tasks.update');
});    

    // Wishlist routes (dynamic)
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
    Route::get('/wishlist/data', [App\Http\Controllers\WishlistController::class, 'data'])->name('wishlist.data');

    /*
|--------------------------------------------------------------------------
| Settings & Product Routes
|--------------------------------------------------------------------------
*/
    Route::get('/settings', [DealershipInfoController::class, 'index'])
        ->name('settings')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/dealership', [DealershipInfoController::class, 'update'])
        ->name('settings.dealership.update')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/ip', [IpRestrictionController::class, 'update'])
        ->name('settings.ip.update')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/store-hours', [StoreHoursController::class, 'update'])
        ->name('settings.store_hours.update')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/security', [SecurityController::class, 'update'])
        ->name('settings.security.update')
        ->middleware('permission:Access To Dealership Settings');

    // Customer Reassignment API & helpers
    Route::get('/settings/customer-reassignment/data', [\App\Http\Controllers\CustomerReassignmentController::class, 'customers'])
        ->name('settings.customer-reassignment.data')
        ->middleware('permission:Access To Dealership Settings');

    Route::post('/settings/customer-reassignment/reassign', [\App\Http\Controllers\CustomerReassignmentController::class, 'reassign'])
        ->name('settings.customer-reassignment.reassign')
        ->middleware('permission:Access To Dealership Settings');

    Route::get('/settings/customer-reassignment/history', [\App\Http\Controllers\CustomerReassignmentController::class, 'history'])
        ->name('settings.customer-reassignment.history')
        ->middleware('permission:Access To Dealership Settings');

    Route::post('/settings/customer-reassignment/undo', [\App\Http\Controllers\CustomerReassignmentController::class, 'undo'])
        ->name('settings.customer-reassignment.undo')
        ->middleware('permission:Access To Dealership Settings');

    // Notification settings (global JSON blob)
    Route::get('/settings/notifications', [\App\Http\Controllers\NotificationSettingController::class, 'show'])
        ->name('settings.notifications.show')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/notifications', [\App\Http\Controllers\NotificationSettingController::class, 'update'])
        ->name('settings.notifications.update')
        ->middleware('permission:Access To Dealership Settings');

    // Email account settings (persisted JSON via NotificationSetting->data.email_account)
    Route::get('/settings/email-account/data', [EmailAccountController::class, 'show'])
        ->name('settings.email_account.data')
        ->middleware('permission:Access To Dealership Settings');

    Route::post('/settings/email-account/update', [EmailAccountController::class, 'update'])
        ->name('settings.email_account.update')
        ->middleware('permission:Access To Dealership Settings');

    Route::get('/settings/email-account/test', [EmailAccountController::class, 'test'])
        ->name('settings.email_account.test')
        ->middleware('permission:Access To Dealership Settings');

    // Holiday overrides (CRUD)
    Route::get('/settings/holidays', [HolidayController::class, 'index'])
        ->name('settings.holidays.index')
        ->middleware('permission:Access To Dealership Settings');

    Route::post('/settings/holidays', [HolidayController::class, 'store'])
        ->name('settings.holidays.store')
        ->middleware('permission:Access To Dealership Settings');

    Route::put('/settings/holidays/{holiday}', [HolidayController::class, 'update'])
        ->name('settings.holidays.update')
        ->middleware('permission:Access To Dealership Settings');

    Route::delete('/settings/holidays/{holiday}', [HolidayController::class, 'destroy'])
        ->name('settings.holidays.destroy')
        ->middleware('permission:Access To Dealership Settings');

    // Merge Sold Deals (dynamic UI)


    Route::get('/settings/merge-sold-deals/data', [MergeSoldDealsController::class, 'data'])
        ->name('settings.merge_sold_deals.data')
        ->middleware('permission:Access To Dealership Settings');

    Route::post('/settings/merge-sold-deals/merge', [MergeSoldDealsController::class, 'merge'])
        ->name('settings.merge_sold_deals.merge')
        ->middleware('permission:Access To Dealership Settings');

    Route::prefix('email-conf')->group(function () {

        Route::post('/save', [App\Http\Controllers\EmailConfigurationController::class, 'save']);
        Route::post('/upload-logo', [App\Http\Controllers\EmailConfigurationController::class, 'uploadLogo']);
        Route::post('/save-social', [App\Http\Controllers\EmailConfigurationController::class, 'saveSocial']);

    })->middleware('permission:Access To Dealership Settings');    

    Route::get('/product-update', function () {
        return view('product-update');
    })->name('product-update');

    /*
|--------------------------------------------------------------------------
| Training & Support Routes
|--------------------------------------------------------------------------
*/
    Route::get('/dealership-training-material', function () {
        return view('dealership-training-material');
    })->name('dealership-training-material');

    Route::get('/contact-support', function () {
        return view('contact-support');
    })->name('contact-support');

    /*
|--------------------------------------------------------------------------
| Reports & Analytics Routes
|--------------------------------------------------------------------------
*/
    Route::get('/reports-analytics', function () {
        return view('reports-analytics');
    })
        ->name('reports-analytics')
        ->middleware('permission:Access Reports & Analytics');
}); // End of auth middleware group

// Local debug route to inspect Telnyx env/config (only available in local environment)

if (app()->environment('local')) {
    Route::get('/telnyx/debug', function () {
        return response()->json([
            'env_telnyx_api_key' => env('TELNYX_API_KEY'),
            'env_telnyx_from' => env('TELNYX_FROM_NUMBER'),
            'env_telnyx_connection_id' => env('TELNYX_CONNECTION_ID'),
            'env_telnyx_allow_simulate' => env('TELNYX_ALLOW_SIMULATE'),
            'services_telnyx' => config('services.telnyx'),
            'config_cached' => file_exists(base_path('bootstrap/cache/config.php')),
        ]);
    });
}


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
require __DIR__ . '/email.php';
require __DIR__ . '/template.php';
require __DIR__ . '/inventory.php';

            Route::get('/customers/all', [CustomerController::class, 'getAllCustomer'])->name('all');


    Route::middleware('permission:View All Dealer Deals/Customer Info')
        ->group(function () {
            

            Route::resource('customers',CustomerController::class);

            // Co-buyer endpoints (save via POST, delete via DELETE)
            Route::post('/customers/{customer}/cobuyer', [CustomerController::class, 'saveCoBuyer'])->name('customers.cobuyer.save');
            Route::delete('/customers/{customer}/cobuyer', [CustomerController::class, 'deleteCoBuyer'])->name('customers.cobuyer.delete');

            // Social links endpoints for modal + save/remove
            Route::get('/customers/{customer}/social/{platform}', [CustomerController::class, 'socialView']);

            Route::get('/customers/all', [CustomerController::class, 'getAllCustomer'])->name('all');
            Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        });

// Ensure social save/remove endpoints are available to authenticated users (avoid permission gate mismatches)
Route::middleware(['auth'])->group(function () {
    Route::post('/customers/{customer}/social/{platform}', [CustomerController::class, 'updateSocial'])->name('customers.social.update');
    Route::delete('/customers/{customer}/social/{platform}', [CustomerController::class, 'deleteSocial'])->name('customers.social.delete');
});



