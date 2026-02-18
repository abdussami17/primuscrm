<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CoBuyer;
use App\Models\CustomerDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;
use Throwable;
use App\Models\CustomerEmail;
use App\Models\Deal;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::with(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser', 'bdcAgentUser'])
            ->withCount('deals');

        // Apply date filter if provided
        if ($request->has('date_field') && $request->has('from_date') && $request->has('to_date')) {
            $dateField = $request->input('date_field');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            // Map frontend field names to database columns
            $fieldMap = [
                'Created Date' => 'created_at',
                'Sold Date' => 'sold_date',
                'Delivery Date' => 'delivery_date',
                'Appointment Date' => 'appointment_date',
                'Last Contacted Date' => 'last_contacted_at',
            ];

            $column = $fieldMap[$dateField] ?? 'created_at';
            $query->whereBetween($column, [$fromDate, $toDate]);
        }

        $customers = $query->orderBy('created_at', 'desc')->get();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'customers' => $customers,
                'html' => view('partials.customers-table-rows', compact('customers'))->render()
            ]);
        }

        $users = User::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get users by role for the form dropdowns
        $salesManagers = User::where('is_active', true)
            ->whereHas('roles', function($q) {
                $q->where('name', 'Sales Manager');
            })
            ->orderBy('name')
            ->get();

        $financeManagers = User::where('is_active', true)
            ->whereHas('roles', function($q) {
                $q->where('name', 'Finance Director');
            })
            ->orderBy('name')
            ->get();

        $bdcAgents = User::where('is_active', true)
            ->whereHas('roles', function($q) {
                $q->where('name', 'BDC Agent');
            })
            ->orderBy('name')
            ->get();

        return view('customers.index', compact('customers', 'users', 'salesManagers', 'financeManagers', 'bdcAgents'));
    }


public function create() {

    return view('customers.create');
}

    /**
     * Return server-rendered social modal fragment for a platform.
     */
    public function socialView(Customer $customer, $platform)
    {
        $map = [
            'facebook' => 'facebook_url',
            'instagram' => 'instagram_url',
            'twitter' => 'twitter_url',
            'youtube' => 'youtube_url',
            'tiktok' => 'tiktok_url',
            'reddit' => 'reddit_url',
        ];

        $col = $map[strtolower($platform)] ?? null;
        $url = $col ? ($customer->{$col} ?? '') : '';

        return view('customers.social_modal', compact('platform', 'customer', 'url'));
    }

    /**
     * Store or update a social link for the customer.
     */
    public function updateSocial(Request $request, Customer $customer, $platform)
    {
        $map = [
            'facebook' => 'facebook_url',
            'instagram' => 'instagram_url',
            'twitter' => 'twitter_url',
            'youtube' => 'youtube_url',
            'tiktok' => 'tiktok_url',
            'reddit' => 'reddit_url',
        ];

        $col = $map[strtolower($platform)] ?? null;
        if (!$col) {
            return response()->json(['success' => false, 'message' => 'Unsupported platform'], 400);
        }

        $data = $request->validate([
            'url' => 'nullable|url|max:2048'
        ]);

        $customer->{$col} = $data['url'] ?? null;
        $customer->save();

        return response()->json(['success' => true, 'url' => $customer->{$col}]);
    }

    /**
     * Delete (clear) a social link for the customer.
     */
    public function deleteSocial(Customer $customer, $platform)
    {
        $map = [
            'facebook' => 'facebook_url',
            'instagram' => 'instagram_url',
            'twitter' => 'twitter_url',
            'youtube' => 'youtube_url',
            'tiktok' => 'tiktok_url',
            'reddit' => 'reddit_url',
        ];

        $col = $map[strtolower($platform)] ?? null;
        if (!$col) {
            return response()->json(['success' => false, 'message' => 'Unsupported platform'], 400);
        }

        $customer->{$col} = null;
        $customer->save();

        return response()->json(['success' => true]);
    }



public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            // Profile & Basic Info
            'profileImage' => 'nullable|image|max:2048',
            'suffix' => 'nullable|string|max:10',
            'businessName' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            
            // Phone Numbers
            'homePhone' => 'nullable|string|max:20',
            'cellPhone' => 'nullable|string|max:20',
            'workPhone' => 'nullable|string|max:20',
            
            // Emails (multiple)
            'emails' => 'required|array|min:1',
            'emails.*' => 'required|email|max:255',
            'defaultEmail' => 'nullable|integer|min:0',
            
            // Address
            'streetAddress' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:20',
            
            // Driver License
            'driver_license_front' => 'nullable|string',
            'driver_license_back' => 'nullable|string',
            
            // Co-Buyer
            'co_buyer_first_name' => 'nullable|string|max:255',
            'co_buyer_middle_name' => 'nullable|string|max:255',
            'co_buyer_last_name' => 'nullable|string|max:255',
            'co_buyer_email' => 'nullable|email|max:255',
            'co_buyer_phone' => 'nullable|string|max:20',
            'co_buyer_cell_phone' => 'nullable|string|max:20',
            'co_buyer_work_phone' => 'nullable|string|max:20',
            'co_buyer_address' => 'nullable|string|max:500',
            'co_buyer_city' => 'nullable|string|max:255',
            'co_buyer_state' => 'nullable|string|max:255',
            'co_buyer_zip_code' => 'nullable|string|max:20',
            
            // Assignment
            'assignedTo' => 'required|exists:users,id',
            'secondaryAssignedTo' => 'nullable|exists:users,id',
            'salesManager' => 'nullable|exists:users,id',
            'financeManager' => 'nullable|exists:users,id',
            'bdcAgent' => 'required|exists:users,id',
            
            // Lead & Deal Info
            'leadType' => 'nullable|string|max:50',
            'leadSource' => 'nullable|string|max:50',
            'salesType' => 'required|string|in:Sales,Service,Parts',
            'dealType' => 'nullable|string|max:50',
            'inventoryType' => 'nullable|string|max:50',
            'leadStatus' => 'required|string|in:Active,Duplicate,Invalid,Lost,Sold,Wishlist,Buy-In',
            
            // Optional Deal-specific fields
            'inventory_id' => 'nullable|exists:inventories,id',
            'price' => 'nullable|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0',
            'trade_in_value' => 'nullable|numeric|min:0',
            'vehicle_description' => 'nullable|string|max:500',
            'deal_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            // Clean and prepare emails
            $emails = $this->prepareEmails($validated['emails']);
            $defaultEmailIndex = (int) ($validated['defaultEmail'] ?? 0);
            
            // Ensure default index is valid
            if ($defaultEmailIndex >= count($emails)) {
                $defaultEmailIndex = 0;
            }

            // Check for duplicate emails across all customers
            $existingEmails = $this->checkExistingEmails($emails);
            
            if (!empty($existingEmails)) {
                 return handleResponse($request, 'The following emails already exist: ' . implode(', ', $existingEmails), 'customers.index',500);
               
            }

            // Get primary email (default one)
            $primaryEmail = $emails[$defaultEmailIndex] ?? $emails[0];

            // Prepare customer data
            $customerData = [
                'suffix' => $validated['suffix'] ?? null,
                'business_name' => $validated['businessName'] ?? null,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middleName'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $primaryEmail, // Primary email for backward compatibility
                'phone' => $validated['homePhone'] ?? null,
                'cell_phone' => $validated['cellPhone'] ?? null,
                'work_phone' => $validated['workPhone'] ?? null,
                'street_address' => $validated['streetAddress'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'zip_code' => $validated['zipCode'] ?? null,
                'driver_license_front' => $validated['driver_license_front'] ?? null,
                'driver_license_back' => $validated['driver_license_back'] ?? null,
                'assigned_to' => $validated['assignedTo'],
                'secondary_assigned_to' => $validated['secondaryAssignedTo'] ?? null,
                'sales_manager' => $validated['salesManager'] ?? null,
                'finance_manager' => $validated['financeManager'] ?? null,
                'bdc_agent' => $validated['bdcAgent'],
                'lead_type' => $validated['leadType'] ?? null,
                'lead_source' => $validated['leadSource'] ?? null,
                'sales_type' => $validated['salesType'],
                'deal_type' => $validated['dealType'] ?? null,
                'inventory_type' => $validated['inventoryType'] ?? null,
                'lead_status' => $validated['leadStatus'],
            ];

            // Handle profile image upload
            if ($request->hasFile('profileImage')) {
                $customerData['profile_image'] = $this->uploadProfileImage($request->file('profileImage'));
            }

            // Create customer
            $customer = Customer::create($customerData);

            // Save all emails to customer_emails table
            $this->saveCustomerEmails($customer, $emails, $defaultEmailIndex);

            // Create co-buyer if provided
            if (!empty($validated['co_buyer_first_name'])) {
                $this->createCoBuyer($customer, $validated);
            }

            //  Create Deal if sales type is 'Sales' and deal data exists
            //  $deal = null;
            // if ($this->shouldCreateDeal($validated)) {*/
            //      $deal = $this->createDeal($customer, $validated);
            // }

            DB::commit();

            // Return success response for AJAX requests (so client can redirect to new profile)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer created successfully!',
                    'customer' => ['id' => $customer->id],
                    'redirect_url' => url('customers/' . $customer->id . '/edit')
                ]);
            }

            // Fallback for non-AJAX requests
            return handleResponse($request, 'Customer created successfully!', 'customers');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Customer creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['profileImage'])
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while creating the customer. Please try again.'
            ], 500);
        }
    }

    /**
     * Prepare and clean emails array.
     */
    private function prepareEmails(array $emails): array
    {
        // Remove empty values, trim, lowercase, and get unique emails
        $cleaned = array_map(function ($email) {
            return strtolower(trim($email));
        }, array_filter($emails, fn($email) => !empty(trim($email))));

        return array_values(array_unique($cleaned));
    }

    /**
     * Check if any emails already exist in the system.
     */
    private function checkExistingEmails(array $emails): array
    {
        // Check in customers table
        $existingInCustomers = Customer::whereIn('email', $emails)->pluck('email')->toArray();
        
        // Check in customer_emails table
        $existingInCustomerEmails = CustomerEmail::whereIn('email', $emails)->pluck('email')->toArray();
        
        return array_unique(array_merge($existingInCustomers, $existingInCustomerEmails));
    }

    /**
     * Save customer emails to the customer_emails table.
     */
    private function saveCustomerEmails(Customer $customer, array $emails, int $defaultIndex): void
    {
        foreach ($emails as $index => $email) {
            CustomerEmail::create([
                'customer_id' => $customer->id,
                'email' => $email,
                'is_default' => $index === $defaultIndex,
                'label' => $index === 0 ? 'primary' : 'additional',
            ]);
        }
    }

    /**
     * Upload profile image and return the path.
     */
    private function uploadProfileImage($image): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/customers'), $imageName);
        return 'uploads/customers/' . $imageName;
    }

    /**
     * Create co-buyer record.
     */
    private function createCoBuyer(Customer $customer, array $validated): void
    {
        $customer->coBuyer()->create([
            'first_name' => $validated['co_buyer_first_name'],
            'middle_name' => $validated['co_buyer_middle_name'] ?? null,
            'last_name' => $validated['co_buyer_last_name'] ?? null,
            'email' => $validated['co_buyer_email'] ?? null,
            'phone' => $validated['co_buyer_phone'] ?? null,
            'cell_phone' => $validated['co_buyer_cell_phone'] ?? null,
            'work_phone' => $validated['co_buyer_work_phone'] ?? null,
            'street_address' => $validated['co_buyer_address'] ?? null,
            'city' => $validated['co_buyer_city'] ?? null,
            'state' => $validated['co_buyer_state'] ?? null,
            'zip_code' => $validated['co_buyer_zip_code'] ?? null,
        ]);
    }

    /**
     * Determine if a deal should be created.
     */
    private function shouldCreateDeal(array $validated): bool
    {
        return !empty($validated['dealType']) || 
                !empty($validated['inventoryType']) || 
                !empty($validated['inventory_id'])
            ;
    }

    /**
     * Create a deal for the customer.
     */
    private function createDeal(Customer $customer, array $validated): Deal
    {
        $dealNumber = $this->generateDealNumber();
        
        return Deal::create([
            'customer_id' => $customer->id,
            'inventory_id' => $validated['inventory_id'] ?? null,
            'deal_number' => $dealNumber,
            'status' => $this->mapLeadStatusToDealStatus($validated['leadStatus']),
            'lead_type' => $validated['leadType'] ?? null,
            'inventory_type' => $validated['inventoryType'] ?? null,
            'vehicle_description' => $validated['vehicle_description'] ?? null,
            'price' => $validated['price'] ?? null,
            'down_payment' => $validated['down_payment'] ?? null,
            'trade_in_value' => $validated['trade_in_value'] ?? null,
            'sold_date' => $validated['leadStatus'] === 'Sold' ? now() : null,
            'sales_person_id' => $validated['assignedTo'],
            'sales_manager_id' => $validated['salesManager'] ?? null,
            'finance_manager_id' => $validated['financeManager'] ?? null,
            'notes' => $validated['deal_notes'] ?? null,
        ]);
    }

    /**
     * Generate a unique deal number.
     */
    private function generateDealNumber(): string
    {
        $prefix = 'DL';
        $year = date('Y');
        $month = date('m');
        
        // Get the last deal number for this month
        $lastDeal = Deal::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastDeal && preg_match('/(\d+)$/', $lastDeal->deal_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    /**
     * Map customer lead status to deal status.
     */
    private function mapLeadStatusToDealStatus(string $leadStatus): string
    {
        $statusMap = [
            'Active' => 'pending',
            'Duplicate' => 'pending',
            'Invalid' => 'cancelled',
            'Lost' => 'lost',
            'Sold' => 'sold',
            'Wishlist' => 'pending',
            'Buy-In' => 'pending',
        ];
        
        return $statusMap[$leadStatus] ?? 'pending';
    }


    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        $customer->load(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser', 'coBuyer']);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    public function edit(Customer $customer){
        $inventory = Inventory::get();

        $customer->load(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser', 'coBuyer']);

        $phoneScripts = collect([
            (object)[ 'id' => 's1', 'name' => 'Follow-up Call' ],
            (object)[ 'id' => 's2', 'name' => 'Sales Introduction' ],
            (object)[ 'id' => 's3', 'name' => 'Service Reminder' ],
            (object)[ 'id' => 's4', 'name' => 'Feedback Request' ],
            (object)[ 'id' => 's5', 'name' => 'Appointment Confirmation' ],
        ]);

        return view('customers.edit', compact('customer','inventory','phoneScripts'));
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, Customer $customer)
    {
        // Build validation rules dynamically based on what's being updated
        $rules = [];

        // Only validate fields that are present in the request
        if ($request->has('profile_image')) {
            $rules['profile_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }
        if ($request->has('first_name')) {
            $rules['first_name'] = 'required|string|max:255';
        }
        if ($request->has('middle_name')) {
            $rules['middle_name'] = 'nullable|string|max:255';
        }
        if ($request->has('last_name')) {
            $rules['last_name'] = 'required|string|max:255';
        }
        if ($request->has('email')) {
            $rules['email'] = 'required|email|unique:customers,email,' . $customer->id;
        }
        if ($request->has('phone')) {
            $rules['phone'] = 'nullable|string|max:20';
        }
        if ($request->has('cell_phone')) {
            $rules['cell_phone'] = 'nullable|string|max:20';
        }
        if ($request->has('work_phone')) {
            $rules['work_phone'] = 'nullable|string|max:20';
        }
        if ($request->has('address')) {
            $rules['address'] = 'nullable|string';
        }
        if ($request->has('city')) {
            $rules['city'] = 'nullable|string|max:255';
        }
        if ($request->has('state')) {
            $rules['state'] = 'nullable|string|max:255';
        }
        if ($request->has('zip_code')) {
            $rules['zip_code'] = 'nullable|string|max:20';
        }
        if ($request->has('country')) {
            $rules['country'] = 'nullable|string|max:255';
        }
        if ($request->has('status')) {
            $rules['status'] = 'nullable|string|max:50';
        }
        if ($request->has('lead_source')) {
            $rules['lead_source'] = 'nullable|string|max:255';
        }
        if ($request->has('assigned_to')) {
            $rules['assigned_to'] = 'nullable|exists:users,id';
        }
        if ($request->has('assigned_manager')) {
            $rules['assigned_manager'] = 'nullable|exists:users,id';
        }
        if ($request->has('secondary_assigned')) {
            $rules['secondary_assigned'] = 'nullable|exists:users,id';
        }
        if ($request->has('bdc_agent')) {
            $rules['bdc_agent'] = 'nullable|exists:users,id';
        }
        if ($request->has('interested_make')) {
            $rules['interested_make'] = 'nullable|string|max:255';
        }
        if ($request->has('interested_model')) {
            $rules['interested_model'] = 'nullable|string|max:255';
        }
        if ($request->has('interested_year')) {
            $rules['interested_year'] = 'nullable|string|max:4';
        }
        if ($request->has('budget')) {
            $rules['budget'] = 'nullable|numeric|min:0';
        }
        if ($request->has('tradein_year')) {
            $rules['tradein_year'] = 'nullable|string|max:4';
        }
        if ($request->has('tradein_make')) {
            $rules['tradein_make'] = 'nullable|string|max:255';
        }
        if ($request->has('tradein_model')) {
            $rules['tradein_model'] = 'nullable|string|max:255';
        }
        if ($request->has('tradein_vin')) {
            $rules['tradein_vin'] = 'nullable|string|max:17';
        }
        if ($request->has('tradein_kms')) {
            $rules['tradein_kms'] = 'nullable|integer|min:0';
        }
        if ($request->has('tradein_value')) {
            $rules['tradein_value'] = 'nullable|numeric|min:0';
        }
        if ($request->has('notes')) {
            $rules['notes'] = 'nullable|string';
        }
        if ($request->has('tags')) {
            $rules['tags'] = 'nullable|array';
        }
        if ($request->has('dealership_franchises')) {
            $rules['dealership_franchises'] = 'nullable|array';
        }
        if ($request->has('consent_marketing')) {
            $rules['consent_marketing'] = 'nullable|boolean';
        }
        if ($request->has('consent_sms')) {
            $rules['consent_sms'] = 'nullable|boolean';
        }
        if ($request->has('consent_email')) {
            $rules['consent_email'] = 'nullable|boolean';
        }

        // Social Media fields
        if ($request->has('facebook_url')) {
            $rules['facebook_url'] = 'nullable|url|max:500';
        }
        if ($request->has('instagram_url')) {
            $rules['instagram_url'] = 'nullable|url|max:500';
        }
        if ($request->has('twitter_url')) {
            $rules['twitter_url'] = 'nullable|url|max:500';
        }
        if ($request->has('youtube_url')) {
            $rules['youtube_url'] = 'nullable|url|max:500';
        }

        // Co-buyer fields
        if ($request->has('co_buyer_first_name')) {
            $rules['co_buyer_first_name'] = 'nullable|string|max:255';
        }
        if ($request->has('co_buyer_middle_name')) {
            $rules['co_buyer_middle_name'] = 'nullable|string|max:255';
        }
        if ($request->has('co_buyer_last_name')) {
            $rules['co_buyer_last_name'] = 'nullable|string|max:255';
        }
        if ($request->has('co_buyer_email')) {
            $rules['co_buyer_email'] = 'nullable|email';
        }
        if ($request->has('co_buyer_phone')) {
            $rules['co_buyer_phone'] = 'nullable|string|max:20';
        }
        if ($request->has('co_buyer_cell_phone')) {
            $rules['co_buyer_cell_phone'] = 'nullable|string|max:20';
        }
        if ($request->has('co_buyer_work_phone')) {
            $rules['co_buyer_work_phone'] = 'nullable|string|max:20';
        }
        if ($request->has('co_buyer_address')) {
            $rules['co_buyer_address'] = 'nullable|string';
        }
        if ($request->has('co_buyer_city')) {
            $rules['co_buyer_city'] = 'nullable|string|max:255';
        }
        if ($request->has('co_buyer_state')) {
            $rules['co_buyer_state'] = 'nullable|string|max:255';
        }
        if ($request->has('co_buyer_zip_code')) {
            $rules['co_buyer_zip_code'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($customer->profile_image && file_exists(public_path($customer->profile_image))) {
                unlink(public_path($customer->profile_image));
            }

            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/customers'), $imageName);
            $validated['profile_image'] = 'uploads/customers/' . $imageName;
        }

        $customer->update($validated);

        // Handle co-buyer update/create/delete
        if ($request->filled('co_buyer_first_name') && $request->filled('co_buyer_last_name')) {
            // Update existing or create new co-buyer
            $customer->coBuyer()->updateOrCreate(
                ['customer_id' => $customer->id],
                [
                    'first_name' => $request->co_buyer_first_name,
                    'middle_name' => $request->co_buyer_middle_name,
                    'last_name' => $request->co_buyer_last_name,
                    'email' => $request->co_buyer_email,
                    'phone' => $request->co_buyer_phone,
                    'cell_phone' => $request->co_buyer_cell_phone,
                    'work_phone' => $request->co_buyer_work_phone,
                    'address' => $request->co_buyer_address,
                    'city' => $request->co_buyer_city,
                    'state' => $request->co_buyer_state,
                    'zip_code' => $request->co_buyer_zip_code,
                ]
            );
        } else {
            // Delete co-buyer if fields are empty
            $customer->coBuyer()->delete();
        }

        return back()->with('success','Customer has been updated successfully!');

      /*  return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully',
            'customer' => $customer->load(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser', 'bdcAgentUser', 'coBuyer'])
        ]);*/
    }

    /**
     * Remove the specified customer (soft delete).
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully'
        ]);
    }

    /**
     * Restore a soft-deleted customer.
     */
    public function restore($id)
    {
        $customer = Customer::withTrashed()->findOrFail($id);
        $customer->restore();

        return response()->json([
            'success' => true,
            'message' => 'Customer restored successfully',
            'customer' => $customer->load(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser'])
        ]);
    }

    /**
     * Bulk delete customers.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:customers,id'
        ]);

        $count = Customer::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => $count . ' customer(s) deleted successfully',
            'count' => $count
        ]);
    }

    /**
     * Merge duplicate customers.
     */
    public function merge(Request $request)
    {
        $validated = $request->validate([
            'main_customer_id' => 'required|exists:customers,id',
            'duplicate_customer_id' => 'required|exists:customers,id',
            'merged_fields' => 'required|array',
            'merged_fields.first_name' => 'nullable|string',
            'merged_fields.middle_name' => 'nullable|string',
            'merged_fields.last_name' => 'nullable|string',
            'merged_fields.cell_phone' => 'nullable|string',
            'merged_fields.phone' => 'nullable|string',
            'merged_fields.work_phone' => 'nullable|string',
            'merged_fields.email' => 'nullable|string',
        ]);

        $mainCustomer = Customer::find($validated['main_customer_id']);
        $duplicateCustomer = Customer::find($validated['duplicate_customer_id']);

        // Clear the duplicate's email to avoid unique constraint violation
        $duplicateCustomer->email = $duplicateCustomer->email . '_deleted_' . time();
        $duplicateCustomer->save();

        // Delete the duplicate customer
        $duplicateCustomer->delete();

        // Then update main customer with selected merged fields
        foreach ($validated['merged_fields'] as $field => $value) {
            if ($value && $value !== '-') {
                $mainCustomer->$field = $value;
            }
        }

        $mainCustomer->save();

        return response()->json([
            'success' => true,
            'message' => 'Customers merged successfully',
            'customer' => $mainCustomer->load(['assignedUser', 'assignedManagerUser', 'secondaryAssignedUser'])
        ]);
    }

    /**
     * Save or update co-buyer for a customer (AJAX)
     */
    public function saveCoBuyer(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'co_first_name' => 'required|string|max:255',
            'co_middle_name' => 'nullable|string|max:255',
            'co_last_name' => 'required|string|max:255',
            'co_email' => 'nullable|email|max:255',
            'co_phone' => 'nullable|string|max:20',
            'co_cell_phone' => 'nullable|string|max:20',
            'co_work_phone' => 'nullable|string|max:20',
            'co_address' => 'nullable|string|max:500',
            'co_city' => 'nullable|string|max:255',
            'co_state' => 'nullable|string|max:255',
            'co_zip_code' => 'nullable|string|max:20',
        ]);

        // If no first/last name provided, delete existing co-buyer
        if (empty($validated['co_first_name']) && empty($validated['co_last_name'])) {
            $customer->coBuyer()->delete();
            return response()->json(['success' => true, 'message' => 'Co-buyer removed']);
        }

        $data = [
            'first_name' => $validated['co_first_name'] ?? null,
            'middle_name' => $validated['co_middle_name'] ?? null,
            'last_name' => $validated['co_last_name'] ?? null,
            'email' => $validated['co_email'] ?? null,
            'phone' => $validated['co_phone'] ?? null,
            'cell_phone' => $validated['co_cell_phone'] ?? null,
            'work_phone' => $validated['co_work_phone'] ?? null,
            'address' => $validated['co_address'] ?? null,
            'city' => $validated['co_city'] ?? null,
            'state' => $validated['co_state'] ?? null,
            'zip_code' => $validated['co_zip_code'] ?? null,
        ];

        $customer->coBuyer()->updateOrCreate(['customer_id' => $customer->id], $data);

        return response()->json(['success' => true, 'message' => 'Co-buyer saved', 'coBuyer' => $customer->coBuyer()->first()]);
    }

    /**
     * Delete co-buyer for a customer (AJAX)
     */
    public function deleteCoBuyer(Customer $customer)
    {
        $customer->coBuyer()->delete();
        return response()->json(['success' => true, 'message' => 'Co-buyer deleted']);
    }
public function getAllCustomer()
{
    $customers = Customer::with('task_deals')->get();

    $data = $customers->map(function ($customer) {
        return [
            'id'    => $customer->id,
            'name'  => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'deals' => $customer->task_deals->map(function ($deal) {
                return [
                    'id'=>$deal->id,
                    'year'       => $deal->vehicle_description,
                    'dealNumber' => $deal->deal_number,
                ];
            })->values(),
        ];
    });

    return response()->json([
        'success'   => true,
        'customers' => $data,
    ]);
}

public function importCustomers(Request $request)
{
    // Log uploaded file details to help debug MIME/extension issues
    if ($request->hasFile('file')) {
        try {
            $file = $request->file('file');
            Log::info('Import upload info', [
                'originalName' => $file->getClientOriginalName(),
                'clientMimeType' => $file->getClientMimeType(),
                'guessedExtension' => $file->guessExtension(),
                'mimeType' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        } catch (\Exception $e) {
            Log::debug('Failed to log upload info: ' . $e->getMessage());
        }
    }

    // Accept common CSV/XLSX file types — some browsers/OSes send text/plain or application/vnd.ms-excel
    $request->validate([
        'file' => [
            'required',
            'mimes:xlsx,csv,txt',
            'mimetypes:text/csv,text/plain,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]
    ]);

    try {

        $importer = new CustomersImport();
        Excel::import($importer, $request->file('file'));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Customers imported successfully.',
                'report' => $importer->report,
            ]);
        }

        // For non-AJAX, flash the report summary to session
        return back()->with('success', 'Customers imported successfully.')->with('import_report', $importer->report);

    } catch (ValidationException $e) {

        // Laravel Excel row validation errors
        $failures = $e->failures();

        $messages = collect($failures)->map(function ($failure) {
            return "Row {$failure->row()}: " . implode(', ', $failure->errors());
        })->implode('<br>');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $messages], 422);
        }

        return back()
            ->withInput()
            ->with('error', $messages);

    } catch (Throwable $e) {

        // Log real error for developers
        Log::error('Customer import failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Import failed. Please check the file format or data integrity.'], 500);
        }

        return back()
            ->withInput()
            ->with('error', 'Import failed. Please check the file format or data integrity.');
    }

    }

    /**
     * Download a sample import template (CSV).
     */
    public function sample()
    {
        $filename = 'customers_sample.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        // Use snake_case / common header names to maximize compatibility with import mapping
        $columns = [
            'first_name','middle_name','last_name','email','dayphone','evephone','cellphone',
            'address','city','state','postalcode','currentsalesrepuserid','bdagentuserid',
            'donotcall','donotemail','donotmail','nickname','email_alt','birthday','wedding_anniversary',
            'marital_status','created_at','last_updated'
        ];

        $sampleRow = [
            'John','A','Doe','john.doe@example.com','555-1234','555-5678','555-9012',
            '123 Main St','Townsville','TX','12345','','',
            '0','0','0','Johnny','j.doe+alt@example.com','1980-01-01','2005-06-15','Single',
            now()->toIso8601String(), now()->toIso8601String()
        ];

        $callback = function() use ($columns, $sampleRow) {
            $out = fopen('php://output', 'w');
            // Write BOM for Excel compatibility
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $columns);
            fputcsv($out, $sampleRow);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}





