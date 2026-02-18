<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerReassignment;
use Illuminate\Support\Facades\Auth;

class CustomerReassignmentController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        // Small static lists for types — could be moved to config
        $leadStatuses = ['new' => 'New', 'qualified' => 'Qualified', 'prospect' => 'Prospect', 'customer' => 'Customer'];
        $leadTypes = ['inbound' => 'Inbound', 'outbound' => 'Outbound', 'referral' => 'Referral', 'website' => 'Website'];
        $inventoryTypes = ['sedan' => 'Sedan', 'suv' => 'SUV', 'truck' => 'Truck', 'convertible' => 'Convertible'];
        $salesStatuses = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'negotiation' => 'Negotiation', 'closed_won' => 'Closed Won'];
        $sources = ['website' => 'Website', 'walk_in' => 'Walk-in', 'referral' => 'Referral', 'phone' => 'Phone', 'email' => 'Email'];
        $dealTypes = ['retail' => 'Retail', 'lease' => 'Lease', 'finance' => 'Finance'];
        $salesTypes = ['cash' => 'Cash', 'finance' => 'Finance', 'lease' => 'Lease'];

        return view('settings.customer-reassignment', compact(
            'users',
            'leadStatuses',
            'leadTypes',
            'inventoryTypes',
            'salesStatuses',
            'sources',
            'dealTypes',
            'salesTypes'
        ));
    }

    public function customers(Request $request)
    {
        $query = Customer::query();
        // apply simple filters
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->input('assigned_to'));
        }
        if ($request->filled('secondary_assigned')) {
            $query->where('secondary_assigned', $request->input('secondary_assigned'));
        }
        if ($request->filled('bdc_agent')) {
            $query->where('bdc_agent', $request->input('bdc_agent'));
        }
        if ($request->filled('lead_status')) {
            $query->where('status', $request->input('lead_status'));
        }
        if ($request->filled('lead_type')) {
            $query->where('lead_source', $request->input('lead_type'));
        }
        if ($request->filled('inventory_type')) {
            $query->where('inventory_type', $request->input('inventory_type'));
        }
        if ($request->filled('start_created')) {
            $query->whereDate('created_at', '>=', $request->input('start_created'));
        }
        if ($request->filled('end_created')) {
            $query->whereDate('created_at', '<=', $request->input('end_created'));
        }

        $customers = $query->with(['assignedUser', 'secondaryAssignedUser', 'bdcAgentUser'])->limit(200)->get();

        return response()->json(['data' => $customers]);
    }

    public function reassign(Request $request)
    {
        $data = $request->validate([
            'customer_ids' => 'required|array',
            'reassign_users' => 'nullable|array',
            'reassign_team' => 'nullable|string'
        ]);

        $userIds = $data['reassign_users'] ?? [];
        $targetUserId = count($userIds) ? $userIds[0] : null;
        $field = 'assigned_to';

        // map team to field
        $team = $data['reassign_team'] ?? null;
        if ($team === 'bdc-agent') {
            $field = 'bdc_agent';
        } elseif ($team === 'secondary') {
            $field = 'secondary_assigned';
        } elseif ($team === 'sales-manager') {
            $field = 'assigned_manager';
        } else {
            $field = 'assigned_to';
        }

        $changedBy = Auth::id();
        $updated = 0;

        foreach ($data['customer_ids'] as $cid) {
            $customer = Customer::find($cid);
            if (! $customer) continue;

            $previous = $customer->{$field};
            $customer->{$field} = $targetUserId;
            $customer->save();

            CustomerReassignment::create([
                'customer_id' => $customer->id,
                'field' => $field,
                'previous_value' => $previous,
                'new_value' => $targetUserId,
                'changed_by' => $changedBy
            ]);

            $updated++;
        }

        return response()->json(['success' => true, 'updated' => $updated]);
    }

    public function history(Request $request)
    {
        $items = CustomerReassignment::with(['customer', 'changedByUser'])->latest()->limit(50)->get();
        return response()->json(['data' => $items]);
    }

    public function undo(Request $request)
    {
        $data = $request->validate([
            'history_ids' => 'required|array'
        ]);

        $restored = 0;
        foreach ($data['history_ids'] as $hid) {
            $entry = CustomerReassignment::find($hid);
            if (! $entry) continue;
            $customer = Customer::find($entry->customer_id);
            if (! $customer) continue;

            // revert
            $customer->{$entry->field} = $entry->previous_value;
            $customer->save();

            // delete history entry to indicate undone
            $entry->delete();
            $restored++;
        }

        return response()->json(['success' => true, 'restored' => $restored]);
    }
}
