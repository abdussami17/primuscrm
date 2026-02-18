<?php

namespace App\Http\Controllers;

use App\Mail\BrochureEmail;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InventoryController extends Controller
{
    /**
     * Display inventory listing with filters and sorting.
     */
    public function inventoryListing(Request $request)
    {
        $query = Inventory::query();
        
        // Default to available inventory
        $query->where('status', $request->get('status', 'available'));
        
        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        
        // Filter by year range
        if ($request->filled('year_min')) {
            $query->where('year', '>=', $request->year_min);
        }
        if ($request->filled('year_max')) {
            $query->where('year', '<=', $request->year_max);
        }
        
        // Filter by make
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }
        
        // Filter by model
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }
        
        // Filter by trim
        if ($request->filled('trim')) {
            $query->where('trim', $request->trim);
        }
        
        // Filter by colors
        if ($request->filled('color_int')) {
            $query->where('interior_color', $request->color_int);
        }
        if ($request->filled('color_ext')) {
            $query->where('exterior_color', $request->color_ext);
        }
        
        // Filter by mileage range
        if ($request->filled('mileage_min')) {
            $query->where('mileage', '>=', $request->mileage_min);
        }
        if ($request->filled('mileage_max')) {
            $query->where('mileage', '<=', $request->mileage_max);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('stock_number', 'like', "%{$search}%")
                ->orWhere('vin', 'like', "%{$search}%")
                ->orWhere('make', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhere('year', 'like', "%{$search}%");
            });
        }
        
        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $allowedSorts = ['stock_number', 'year', 'make', 'model', 'price', 'mileage', 'created_at'];
        
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDir === 'asc' ? 'asc' : 'desc');
        }
        
        // Pagination
        $perPage = $request->get('per_page', 15);
        $inventory = $query->paginate($perPage);
        
        // Get filter options for dropdowns (distinct values)
        $makes = Inventory::where('status', 'available')
            ->distinct()
            ->pluck('make')
            ->filter()
            ->sort()
            ->values();
            
        $models = Inventory::where('status', 'available')
            ->distinct()
            ->pluck('model')
            ->filter()
            ->sort()
            ->values();
            
        $trims = Inventory::where('status', 'available')
            ->distinct()
            ->pluck('trim')
            ->filter()
            ->sort()
            ->values();
            
        $interiorColors = Inventory::where('status', 'available')
            ->distinct()
            ->pluck('interior_color')
            ->filter()
            ->sort()
            ->values();
            
        $exteriorColors = Inventory::where('status', 'available')
            ->distinct()
            ->pluck('exterior_color')
            ->filter()
            ->sort()
            ->values();

        // --- NEW: build users list from customers for email suggestions ---
        // Only include customers that have an email. Adjust query if you prefer 'users' table instead.
        $users = Customer::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->select(['id', 'first_name', 'last_name', 'email'])
            ->get()
            ->map(function ($c) {
                $name = trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? ''));
                return [
                    'id' => $c->id,
                    'name' => $name ?: $c->email,
                    'email' => $c->email,
                ];
            })
            ->sortBy('name')
            ->values()
            ->all(); // array for easy JSON encoding in view
        // -----------------------------------------------------------------

        return view('inventory.index', compact(
            'inventory',
            'makes',
            'models',
            'trims',
            'interiorColors',
            'exteriorColors',
            'users' // <- pass users to the view
        ));
    }
        
    /**
     * Get availability/hold details for a vehicle (API).
     */
    public function getAvailability(Inventory $inventory)
    {
        // Derive interested customers from deals related to this inventory.
        $deals = $inventory->deals()
            ->with('customer.assignedTo')
            ->orderBy('created_at', 'desc')
            ->get();

        $customers = $deals->map(function ($deal) {
            $customer = $deal->customer;
            if (!$customer) return null;

            // prefer an explicit hold_date on the deal if present, otherwise use deal creation time
            $hold = $deal->hold_date ?? $deal->created_at ?? null;

            return [
                'id' => $customer->id,
                'name' => $customer->full_name,
                'assigned_to' => $customer->assignedTo?->name ?? 'Unassigned',
                'hold_date' => $hold?->format('M d, Y'),
                'hold_time' => $hold?->format('h:i A'),
            ];
        })->filter()->values();
        
        return response()->json([
            'success' => true,
            'vehicle' => [
                'name' => "{$inventory->year} {$inventory->make} {$inventory->model}",
                'stock_number' => $inventory->stock_number,
                'vin' => $inventory->vin,
            ],
            'customers' => $customers,
        ]);
    }
    
    /**
     * Get price details for a vehicle (API).
     */
    public function getPriceDetails(Inventory $inventory)
    {
        $history = $inventory->priceHistory()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($record) {
                return [
                    'user' => $record->user?->name ?? 'System',
                    'date' => $record->created_at->format('M d, Y h:i:s A'),
                ];
            });
        
        return response()->json([
            'success' => true,
            'inventory' => [
                'id' => $inventory->id,
                'msrp' => $inventory->msrp,
                'price' => $inventory->price,
                'internet_price' => $inventory->internet_price,
                'condition' => $inventory->condition,
            ],
            'history' => $history,
        ]);
    }
    
    /**
     * Update inventory price.
     */
    public function updatePrice(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'selling_price' => 'nullable|string',
            'internet_price' => 'nullable|string',
            'msrp' => 'nullable|string',
        ]);
        
        $inventory = Inventory::findOrFail($request->inventory_id);
        
        // Parse currency strings to numbers
        $inventory->price = $this->parseCurrency($request->selling_price);
        $inventory->internet_price = $this->parseCurrency($request->internet_price);
        $inventory->msrp = $this->parseCurrency($request->msrp);
        
        if ($request->filled('condition')) {
            $inventory->condition = $request->condition;
        }
        
        $inventory->save();
        
        // Log price change
        $inventory->priceHistory()->create([
            'user_id' => auth()->id(),
            'price' => $inventory->price,
            'internet_price' => $inventory->internet_price,
        ]);
        
        // If this was an AJAX request, return JSON so frontend can handle modal/toast
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Price updated successfully.',
                'inventory' => [
                    'id' => $inventory->id,
                    'price' => $inventory->price,
                    'internet_price' => $inventory->internet_price,
                    'msrp' => $inventory->msrp,
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Price updated successfully.');
    }
    
    /**
     * Get images for a vehicle (API).
     */
    public function getImages(Inventory $inventory)
    {
        $images = is_array($inventory->images) 
            ? $inventory->images 
            : json_decode($inventory->images, true) ?? [];
        
        return response()->json([
            'success' => true,
            'images' => $images,
        ]);
    }
    
    /**
     * Update inventory images.
     */
    public function updateImages(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'images.*' => 'nullable|image|max:5120',
        ]);
        
        $inventory = Inventory::findOrFail($request->inventory_id);
        
        $existingImages = is_array($inventory->images) 
            ? $inventory->images 
            : json_decode($inventory->images, true) ?? [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('inventory/' . $inventory->id, 'public');
                $existingImages[] = '/storage/' . $path;
            }
        }
        
        $inventory->images = $existingImages;
        $inventory->save();
        
        return redirect()->back()->with('success', 'Images updated successfully.');
    }
    
    /**
     * Get book value from vAuto (API).
     */
    public function getBookValue(Inventory $inventory)
    {
        // Placeholder for vAuto integration
        // In production, this would call the vAuto API
        $bookValue = $inventory->price * 0.85; // Simulated value
        
        return response()->json([
            'success' => true,
            'value' => $bookValue,
        ]);
    }
    
    /**
     * Send brochure email.
     */

    public function sendBrochure(Request $request)
    {
        $request->validate([
            'inventory_id' => 'nullable|exists:inventories,id',
            'email_to'     => 'required|email',
            'email_cc'     => 'nullable|string',
            'email_bcc'    => 'nullable|string',
            'subject'      => 'required|string|max:255',
            'email_body'   => 'required|string',
        ]);

        $body = $request->input('email_body', '');
        $subject = $request->input('subject', 'Vehicle Brochure');

        $inventory = null;
        if ($request->filled('inventory_id')) {
            $inventory = Inventory::find($request->input('inventory_id'));
        }

        // Try to resolve a Customer record by recipient email so we can fill customer merge fields
        $customer = Customer::where('email', $request->input('email_to'))->first();

        // Replace merge fields in body and subject
        $processedBody = $this->replaceMergeFields($body, $inventory, $customer);
        $processedSubject = $this->replaceMergeFields($subject, $inventory, $customer);

        // Optional: sanitize HTML if you accept user-provided HTML (recommended)
        // if (class_exists('\Purifier')) {
        //     $processedBody = \Purifier::clean($processedBody, 'email');
        // }

        // Parse CC/BCC comma-separated lists
        $ccs = collect(explode(',', $request->input('email_cc', '')))
                ->map(fn($s) => trim($s))
                ->filter()->unique()->all();
        $bccs = collect(explode(',', $request->input('email_bcc', '')))
                ->map(fn($s) => trim($s))
                ->filter()->unique()->all();

        $mailable = new BrochureEmail($processedBody, $processedSubject);

        try {
            $mail = Mail::to($request->input('email_to'));
            if (!empty($ccs)) $mail = $mail->cc($ccs);
            if (!empty($bccs)) $mail = $mail->bcc($bccs);

            $mail->send($mailable);

            Log::info('Brochure sent', [
                'to' => $request->input('email_to'),
                'cc' => $ccs,
                'bcc' => $bccs,
                'subject' => $processedSubject,
                'inventory_id' => $inventory?->id,
                'customer_id' => $customer?->id,
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Brochure email sent successfully.');
        } catch (\Throwable $e) {
            Log::error('Brochure send failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $request->only(['email_to','email_cc','email_bcc','subject','inventory_id'])
            ]);

            return redirect()->back()->with('error', 'Failed to send brochure email. Please try again.');
        }
    }
    
    /**
     * Parse currency string to float.
     */
    private function parseCurrency(?string $value): ?float
    {
        if (empty($value)) {
            return null;
        }
        
        return (float) preg_replace('/[^0-9.]/', '', $value);
    }
    
    private function replaceMergeFields(string $content, ?Inventory $inventory = null, $customer = null): string
    {
        // Start with an empty mapping
        $replacements = [];

        // 1) Inventory fields
        if ($inventory) {
            $replacements = array_merge($replacements, [
                'year' => $inventory->year,
                'make' => $inventory->make,
                'model' => $inventory->model,
                'vin' => $inventory->vin,
                'stock_number' => $inventory->stock_number,
                // price/internet_price formatted with currency and commas
                'selling_price' => $inventory->price !== null ? ('$' . number_format((float)$inventory->price, 0, '.', ',')) : '',
                'internet_price' => $inventory->internet_price !== null ? ('$' . number_format((float)$inventory->internet_price, 0, '.', ',')) : '',
                'kms' => $inventory->mileage !== null ? number_format((float)$inventory->mileage, 0, '.', ',') : '',
            ]);
        }

        // 2) Customer fields (if provided or attempt to leave empty)
        if ($customer) {
            $replacements = array_merge($replacements, [
                'first_name' => $customer->first_name ?? '',
                'last_name' => $customer->last_name ?? '',
                'email' => $customer->email ?? '',
                'alt_email' => $customer->alt_email ?? '',
                'cell_phone' => $customer->cell_phone ?? '',
                'work_phone' => $customer->work_phone ?? '',
                'home_phone' => $customer->home_phone ?? '',
                'street_address' => $customer->address ?? ($customer->street_address ?? ''),
                'city' => $customer->city ?? '',
                'province' => $customer->province ?? ($customer->state ?? ''),
                'postal_code' => $customer->zip_code ?? ($customer->postal_code ?? ''),
                'country' => $customer->country ?? '',
            ]);
        }

        // 3) Dealer / Company / Advisor fields
        // Prefer configuration or env variables; fallback to app name / auth user.
        $dealerName = config('app.dealer_name') ?? env('DEALER_NAME') ?? config('app.name');
        $dealerPhone = config('app.dealer_phone') ?? env('DEALER_PHONE') ?? '';
        $dealerAddress = config('app.dealer_address') ?? env('DEALER_ADDRESS') ?? '';
        $dealerWebsite = config('app.dealer_website') ?? env('DEALER_WEBSITE') ?? '';

        $advisorName = null;
        if (auth()->check()) {
            $advisorName = trim(auth()->user()->name ?? (auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? ''));
        }
        // allow override if customer has an advisor field
        if (!$advisorName && $customer) {
            $advisorName = $customer->advisor_name ?? null;
        }
        $advisorName = $advisorName ?: '';

        $replacements = array_merge($replacements, [
            'dealer_name' => $dealerName,
            'dealer_phone' => $dealerPhone,
            'dealer_address' => $dealerAddress,
            'dealer_website' => $dealerWebsite,
            'advisor_name' => $advisorName,
            'assigned_to' => $advisorName,
            // add placeholders for assigned_manager etc if needed
        ]);

        // 4) Allow additional / legacy aliases
        $replacements['assigned_manager'] = $replacements['assigned_manager'] ?? ($customer->assigned_manager ?? '');

        // 5) Do replacement using regex that matches both {{token}} and @{{ token }}
        if (!empty($replacements)) {
            foreach ($replacements as $key => $value) {
                $value = (string) ($value ?? '');
                // Build a regex that matches @{{ key }} or {{ key }}, allow optional spaces
                $pattern = '/@?\{\{\s*' . preg_quote($key, '/') . '\s*\}\}/i';
                $content = preg_replace($pattern, $value, $content);
            }
        }

        // 6) Safety: also replace tokens without underscores/spaces (older templates like {{first_name}})
        // The above already handles no-spaces; but to catch tokens with uppercase or slight variations,
        // also replace common variants if needed (optional).

        return $content;
    }

    public function index(Request $request)
    {
        $query = Inventory::query();

        // Default to available inventory
        if (!$request->has('status')) {
            $query->available();
        } else {
            $query->where('status', $request->status);
        }

        // Filter by condition (new, used, cpo)
        if ($request->has('condition')) {
            $query->condition($request->condition);
        }

        // Filter by year range
        if ($request->has('year_from')) {
            $query->where('year', '>=', $request->year_from);
        }
        if ($request->has('year_to')) {
            $query->where('year', '<=', $request->year_to);
        }

        // Filter by make
        if ($request->has('make')) {
            $query->where('make', $request->make);
        }

        // Filter by model
        if ($request->has('model')) {
            $query->where('model', $request->model);
        }

        // Filter by price range
        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Filter by mileage
        if ($request->has('mileage_max')) {
            $query->where('mileage', '<=', $request->mileage_max);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $query->orderBy($sortField, $sortDir);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $inventory = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $inventory->items(),
            'pagination' => [
                'current_page' => $inventory->currentPage(),
                'last_page' => $inventory->lastPage(),
                'per_page' => $inventory->perPage(),
                'total' => $inventory->total(),
            ]
        ]);
    }

    /**
     * Search inventory by keyword.
     */
    public function search(Request $request)
    {
        $query = $request->get('search', $request->get('q', ''));
        
        $inventory = Inventory::available()
            ->where(function($q) use ($query) {
                $q->where('vin', 'LIKE', "%{$query}%")
                  ->orWhere('stock_number', 'LIKE', "%{$query}%")
                  ->orWhere('year', 'LIKE', "%{$query}%")
                  ->orWhere('make', 'LIKE', "%{$query}%")
                  ->orWhere('model', 'LIKE', "%{$query}%")
                  ->orWhere('trim', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(year, ' ', make, ' ', model) LIKE ?", ["%{$query}%"]);
            })
            ->orderBy('year', 'desc')
            ->limit($request->get('limit', 20))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $inventory,
            'count' => $inventory->count()
        ]);
    }

    /**
     * Get single inventory item.
     */
    public function show(Inventory $inventory)
    {
        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    /**
     * Get available makes for filters.
     */
    public function getMakes()
    {
        $makes = Inventory::available()
            ->select('make')
            ->distinct()
            ->orderBy('make')
            ->pluck('make');

        return response()->json([
            'success' => true,
            'data' => $makes
        ]);
    }

    /**
     * Get models for a specific make.
     */
    public function getModels(Request $request)
    {
        $make = $request->get('make');
        
        $models = Inventory::available()
            ->where('make', $make)
            ->select('model')
            ->distinct()
            ->orderBy('model')
            ->pluck('model');

        return response()->json([
            'success' => true,
            'data' => $models
        ]);
    }
}