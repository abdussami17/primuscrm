<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Inventory;
use App\Models\ServiceHistory;
use App\Models\TradeIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class DealController extends Controller
{


     public function vehiclePartial(Deal $deal)
    {
        $vehicle = $deal->vehicle; // adjust relationship name if needed
        $dealId=$deal->id;

        if (!$vehicle) {
            return response()
                ->view('customers.partials.vehicles.vehicle-empty', compact('dealId'), 200);
        }

        return response()
            ->view('customers.partials.vehicles.vehicle-details', compact('vehicle','dealId'), 200);
    }


    /**
     * Get deals for a specific customer.
     */
    public function getCustomerDeals($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        
        $deals = Deal::where('customer_id', $customerId)
            ->with([
                'customer:id,first_name,last_name,email',
                'salesPerson:id,name',
                'salesManager:id,name',
                'financeManager:id,name',
                'inventory:id,year,make,model,trim,vin,stock_number,price,images'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'customer' => $customer,
            'deals' => $deals
        ]);
    }

    /**
     * Store a new deal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'inventory_id' => 'nullable|exists:inventory,id',
            'deal_number' => 'nullable|string|unique:deals,deal_number',
            'status' => 'nullable|string',
            'lead_type' => 'nullable|string',
            'inventory_type' => 'nullable|string',
            'vehicle_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0',
            'trade_in_value' => 'nullable|numeric|min:0',
            'sold_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'sales_person_id' => 'nullable|exists:users,id',
            'sales_manager_id' => 'nullable|exists:users,id',
            'finance_manager_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'deal_type' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        // Auto-generate deal number if not provided
        if (empty($validated['deal_number'])) {
            $validated['deal_number'] = 'DL-' . strtoupper(uniqid());
        }

        $validated['created_by'] = Auth::id();

        DB::beginTransaction();
        try {
            $deal = Deal::create($validated);

            // Log activity
            Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'deal_created',
                'description' => "Deal #{$deal->deal_number} created"
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Deal created successfully',
                'deal' => $deal->load(['salesPerson', 'salesManager', 'financeManager'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create deal: ' . $e->getMessage()
            ], 500);
        }
    }


    

    /**
     * Get a single deal.
     */
    public function show(Deal $deal)
    {
        return response()->json([
            'success' => true,
            'deal' => $deal->load([
                'customer',
                'salesPerson',
                'salesManager',
                'financeManager',
                'inventory',
                'tradeIn',
                'tasks',
                'notes'
            ])
        ]);
    }

    /**
     * Update a deal.
     */
    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'inventory_id' => 'nullable|exists:inventory,id',
            'status' => 'nullable|string',
            'lead_type' => 'nullable|string',
            'inventory_type' => 'nullable|string',
            'vehicle_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0',
            'trade_in_value' => 'nullable|numeric|min:0',
            'sold_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'sales_person_id' => 'nullable|exists:users,id',
            'sales_manager_id' => 'nullable|exists:users,id',
            'finance_manager_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'deal_type' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        // Track changes for activity log
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($deal->$key != $value) {
                $changes[$key] = [
                    'from' => $deal->$key,
                    'to' => $value
                ];
            }
        }

        $deal->update($validated);

        // Log significant changes
        if (!empty($changes)) {
            $changeDescriptions = [];
            foreach ($changes as $field => $change) {
                $fieldName = ucwords(str_replace('_', ' ', $field));
                $changeDescriptions[] = "{$fieldName} changed from '{$change['from']}' to '{$change['to']}'";
            }

      Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'status_change',
                'description' => implode(', ', $changeDescriptions)
            ]);

          
        }

        return response()->json([
            'success' => true,
            'message' => 'Deal updated successfully',
            'deal' => $deal->load(['salesPerson', 'salesManager', 'financeManager'])
        ]);
    }

    /**
     * Delete a deal.
     */
    public function destroy(Deal $deal)
    {
        $dealNumber = $deal->deal_number;
        $customerId = $deal->customer_id;

        $deal->delete();

        Activity::create([
            'customer_id' => $customerId,
            'user_id' => Auth::id(),
            'type' => 'deal_deleted',
            'description' => "Deal #{$dealNumber} was deleted"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Deal deleted successfully'
        ]);
    }

    /**
     * Get vehicle information for a deal.
     */
    public function getVehicle(Deal $deal)
    {
        $vehicle = $deal->inventory;
        $tradeIn = TradeIn::where('deal_id', $deal->id)->first();
        $serviceHistory = [];

        if ($vehicle) {
            $serviceHistory = ServiceHistory::where('inventory_id', $vehicle->id)
                ->orderBy('date', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
            'trade_in' => $tradeIn,
            'service_history' => $serviceHistory
        ]);
    }

    /**
     * Get activities for a deal.
     */
    public function getActivities(Deal $deal)
    {
        $activities = Activity::where('deal_id', $deal->id)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    /**
     * Update deal field (for inline editing).
     */
    public function updateField(Request $request, Deal $deal)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = [
            'status', 'lead_type', 'inventory_type', 'deal_type', 'source',
            'sales_person_id', 'sales_manager_id', 'finance_manager_id',
            'price', 'down_payment', 'trade_in_value', 'notes',
            'sales_status', 'sold_date', 'delivery_date', 'created_at'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid field'
            ], 400);
        }

        // Special handling for sales_status and related dates
        if ($field === 'sales_status') {
            $oldValue = $deal->sales_status;
            $deal->sales_status = $value;

            // if sold_date provided in request, validate it
            $soldDate = $request->input('sold_date');
            if ($soldDate) {
                $d = date_create($soldDate);
                if (!$d) {
                    return response()->json(['success' => false, 'message' => 'Invalid sold_date'], 400);
                }
                $now = new \DateTime();
                $dDt = new \DateTime($soldDate);
                if ($dDt > $now) {
                    return response()->json(['success' => false, 'message' => 'Sold date cannot be in the future'], 400);
                }
                $deal->sold_date = $dDt->format('Y-m-d');
            }

            // if delivery_date provided in request, validate it
            $deliveryDate = $request->input('delivery_date');
            if ($deliveryDate) {
                $d = date_create($deliveryDate);
                if (!$d) {
                    return response()->json(['success' => false, 'message' => 'Invalid delivery_date'], 400);
                }
                $deal->delivery_date = (new \DateTime($deliveryDate))->format('Y-m-d');
                $deal->status = strtolower($value) === 'delivered' ? 'Delivered' : $deal->status;
            }

            // If marking as sold, set status text accordingly
            if (strtolower($value) === 'sold') {
                $deal->status = 'Sold';
            }

            $deal->save();

            // Log activity
            Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'field_update',
                'description' => "Sales Status changed from '{$oldValue}' to '{$value}'"
            ]);

            return response()->json(['success' => true, 'message' => 'Field updated', 'deal' => $deal]);
        }

        if ($field === 'sold_date') {
            // validate sold_date
            $d = date_create($value);
            if (!$d) {
                return response()->json(['success' => false, 'message' => 'Invalid sold_date'], 400);
            }
            $now = new \DateTime();
            $dDt = new \DateTime($value);
            if ($dDt > $now) {
                return response()->json(['success' => false, 'message' => 'Sold date cannot be in the future'], 400);
            }
            $oldValue = $deal->sold_date;
            $deal->sold_date = $dDt->format('Y-m-d');
            $deal->save();

            Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'field_update',
                'description' => "Sold Date changed from '{$oldValue}' to '{$deal->sold_date}'"
            ]);

            return response()->json(['success' => true, 'message' => 'Sold date updated', 'deal' => $deal]);
        }

        if ($field === 'delivery_date') {
            // validate delivery_date (future dates allowed)
            $d = date_create($value);
            if (!$d) {
                return response()->json(['success' => false, 'message' => 'Invalid delivery_date'], 400);
            }
            $oldValue = $deal->delivery_date;
            $deal->delivery_date = (new \DateTime($value))->format('Y-m-d');
            $deal->save();

            Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'field_update',
                'description' => "Delivery Date changed from '{$oldValue}' to '{$deal->delivery_date}'"
            ]);

            return response()->json(['success' => true, 'message' => 'Delivery date updated', 'deal' => $deal]);
        }

        if ($field === 'created_at') {
            // Allow editing the created date
            $d = date_create($value);
            if (!$d) {
                return response()->json(['success' => false, 'message' => 'Invalid created_at date'], 400);
            }
            $oldValue = $deal->created_at;
            $deal->created_at = \Carbon\Carbon::parse($value)->startOfDay();
            $deal->save();

            Activity::create([
                'deal_id' => $deal->id,
                'customer_id' => $deal->customer_id,
                'user_id' => Auth::id(),
                'type' => 'field_update',
                'description' => "Created Date changed from '{$oldValue}' to '{$deal->created_at}'"
            ]);

            return response()->json(['success' => true, 'message' => 'Created date updated', 'deal' => $deal]);
        }

        // Default handling for other fields
        $oldValue = $deal->$field;
        $deal->$field = $value;
        $deal->save();

        // Log activity
        $fieldName = ucwords(str_replace('_', ' ', $field));
        Activity::create([
            'deal_id' => $deal->id,
            'customer_id' => $deal->customer_id,
            'user_id' => Auth::id(),
            'type' => 'field_update',
            'description' => "{$fieldName} changed from '{$oldValue}' to '{$value}'"
        ]);

        return response()->json(['success' => true, 'message' => 'Field updated', 'deal' => $deal]);
    }
}