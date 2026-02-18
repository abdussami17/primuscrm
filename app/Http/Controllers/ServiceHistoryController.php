<?php

namespace App\Http\Controllers;

use App\Models\ServiceHistory;
use Illuminate\Http\Request;

class ServiceHistoryController extends Controller
{
    /**
     * Get service history for an inventory item
     */
    public function index(Request $request)
    {
        $query = ServiceHistory::with(['advisor:id,name']);

        if ($request->has('inventory_id')) {
            $query->where('inventory_id', $request->inventory_id);
        }

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $history = $query->orderBy('service_date', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    /**
     * Store new service record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'nullable|exists:inventory,id',
            'customer_id' => 'nullable|exists:customers,id',
            'service_date' => 'required|date',
            'service_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'mileage' => 'nullable|integer',
            'cost' => 'nullable|numeric|min:0',
            'advisor_id' => 'nullable|exists:users,id',
            'advisor_name' => 'nullable|string|max:100',
            'technician' => 'nullable|string|max:100',
            'labor_hours' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'ro_number' => 'nullable|string|max:50',
        ]);

        $record = ServiceHistory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service record created',
            'data' => $record
        ]);
    }

    /**
     * Update service record
     */
    public function update(Request $request, ServiceHistory $serviceHistory)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
            'service_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'mileage' => 'nullable|integer',
            'cost' => 'nullable|numeric|min:0',
            'technician' => 'nullable|string|max:100',
            'labor_hours' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $serviceHistory->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service record updated',
            'data' => $serviceHistory
        ]);
    }

    /**
     * Delete service record
     */
    public function destroy(ServiceHistory $serviceHistory)
    {
        $serviceHistory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service record deleted'
        ]);
    }
}