<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulkDeleteController extends Controller
{
    /**
     * Get filter options for bulk delete
     */
    public function getFilters()
    {
        return response()->json([
            'users' => User::where('is_active', 1)
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),
            'sources' => Customer::distinct()
                ->whereNotNull('lead_source')
                ->pluck('lead_source')
                ->filter()
                ->values(),
            'statuses' => Customer::distinct()
                ->whereNotNull('status')
                ->pluck('status')
                ->filter()
                ->values(),
            'inventory_types' => Customer::distinct()
                ->whereNotNull('inventory_type')
                ->pluck('inventory_type')
                ->filter()
                ->values(),
            'deal_types' => Deal::distinct()
                ->whereNotNull('deal_type')
                ->pluck('deal_type')
                ->filter()
                ->values(),
            'lead_types' => Deal::distinct()
                ->whereNotNull('lead_type')
                ->pluck('lead_type')
                ->filter()
                ->values(),
        ]);
    }

    /**
     * Get customers (leads) with filters
     */
    public function getCustomers(Request $request)
    {
        $query = Customer::with([
            'assignedUser:id,name',
            'assignedManagerUser:id,name',
            'secondaryAssignedUser:id,name',
            'bdcAgentUser:id,name',
            'deals' => function($q) {
                $q->latest()->limit(1);
            }
        ]);

        // Apply filters
        if ($request->filled('assigned_manager')) {
            $query->where('assigned_manager', $request->assigned_manager);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('secondary_assigned')) {
            $query->where('secondary_assigned', $request->secondary_assigned);
        }

        if ($request->filled('bdc_agent')) {
            $query->where('bdc_agent', $request->bdc_agent);
        }

        if ($request->filled('lead_source')) {
            $query->where('lead_source', $request->lead_source);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('inventory_type')) {
            $query->where('inventory_type', $request->inventory_type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by deal-related fields
        if ($request->filled('deal_type')) {
            $query->whereHas('deals', function($q) use ($request) {
                $q->where('deal_type', $request->deal_type);
            });
        }

        if ($request->filled('lead_type')) {
            $query->whereHas('deals', function($q) use ($request) {
                $q->where('lead_type', $request->lead_type);
            });
        }

        $customers = $query->latest()->get();

        $data = $customers->map(function($customer) {
            $latestDeal = $customer->deals->first();
            
            return [
                'id' => $customer->id,
                'customer_name' => $customer->full_name,
                'sales_type' => $latestDeal ? $latestDeal->deal_type : 'N/A',
                'lead_type' => $latestDeal ? $latestDeal->lead_type : 'N/A',
                'lead_status' => $customer->status ?? 'N/A',
                'inventory_type' => $customer->inventory_type ?? 'N/A',
                'sales_status' => $latestDeal ? $latestDeal->status : 'N/A',
                'created_date' => $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A',
                'source' => $customer->lead_source ?? 'N/A',
                'deal_type' => $latestDeal ? $latestDeal->deal_type : 'N/A',
                'assigned_to' => $customer->assignedUser ? $customer->assignedUser->name : 'N/A',
                'secondary_assigned' => $customer->secondaryAssignedUser ? $customer->secondaryAssignedUser->name : 'N/A',
                'bdc_agent' => $customer->bdcAgentUser ? $customer->bdcAgentUser->name : 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'items' => $data,
        ]);
    }

    /**
     * Get deletion history (grouped by deleted_at timestamps)
     */
    public function getDeletionHistory()
    {
        $history = Customer::onlyTrashed()
            ->select('id', 'first_name', 'last_name', 'deleted_at', 'deleted_by')
            ->orderBy('deleted_at', 'desc')
            ->get()
            ->map(function($item) {
                $datetime = $item->deleted_at->format('M d, Y; h:i A');
                $customerName = trim($item->first_name . ' ' . $item->last_name);
                
                return [
                    'value' => $item->deleted_at->format('Y-m-d H:i:s') . '|' . ($item->deleted_by ?? ''),
                    'label' => $datetime . ' - ' . ($customerName ?: 'Unknown Customer'),
                ];
            });

        return response()->json($history);
    }

    /**
     * Get deleted customers
     */
    public function getDeletedCustomers(Request $request)
    {
        $query = Customer::onlyTrashed()
            ->with([
                'assignedUser:id,name',
                'assignedManagerUser:id,name',
                'secondaryAssignedUser:id,name',
                'bdcAgentUser:id,name',
                'deals' => function($q) {
                    $q->latest()->limit(1);
                }
            ]);

        // Filter by deletion history (datetime + user)
        if ($request->filled('deletion_date')) {
            $parts = explode('|', $request->deletion_date);
            if (count($parts) === 2) {
                $query->where('deleted_at', $parts[0])
                      ->where('deleted_by', $parts[1]);
            }
        }

        // Apply filters
        if ($request->filled('assigned_manager')) {
            $query->where('assigned_manager', $request->assigned_manager);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('secondary_assigned')) {
            $query->where('secondary_assigned', $request->secondary_assigned);
        }

        if ($request->filled('bdc_agent')) {
            $query->where('bdc_agent', $request->bdc_agent);
        }

        if ($request->filled('lead_source')) {
            $query->where('lead_source', $request->lead_source);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('inventory_type')) {
            $query->where('inventory_type', $request->inventory_type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $customers = $query->latest('deleted_at')->get();

        $data = $customers->map(function($customer) {
            $latestDeal = $customer->deals->first();
            
            return [
                'id' => $customer->id,
                'customer_name' => $customer->full_name,
                'sales_type' => $latestDeal ? $latestDeal->deal_type : 'N/A',
                'lead_type' => $latestDeal ? $latestDeal->lead_type : 'N/A',
                'lead_status' => $customer->status ?? 'N/A',
                'inventory_type' => $customer->inventory_type ?? 'N/A',
                'sales_status' => $latestDeal ? $latestDeal->status : 'N/A',
                'created_date' => $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A',
                'source' => $customer->lead_source ?? 'N/A',
                'deal_type' => $latestDeal ? $latestDeal->deal_type : 'N/A',
                'assigned_to' => $customer->assignedUser ? $customer->assignedUser->name : 'N/A',
                'secondary_assigned' => $customer->secondaryAssignedUser ? $customer->secondaryAssignedUser->name : 'N/A',
                'bdc_agent' => $customer->bdcAgentUser ? $customer->bdcAgentUser->name : 'N/A',
                'deleted_date' => $customer->deleted_at ? $customer->deleted_at->format('M d, Y') : 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'items' => $data,
        ]);
    }

    /**
     * Bulk delete customers
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'required|integer|exists:customers,id',
        ]);

        try {
            $userId = Auth::id();
            $now = now();
            
            // Update deleted_by and deleted_at, then soft delete
            Customer::whereIn('id', $request->customer_ids)
                ->update(['deleted_by' => $userId]);
            
            $deletedCount = Customer::whereIn('id', $request->customer_ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} customer(s) deleted successfully",
                'deleted_count' => $deletedCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customers: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk restore customers
     */
    public function bulkRestore(Request $request)
    {
        $request->validate([
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'required|integer',
        ]);

        try {
            $restoredCount = Customer::onlyTrashed()
                ->whereIn('id', $request->customer_ids)
                ->restore();

            return response()->json([
                'success' => true,
                'message' => "{$restoredCount} customer(s) restored successfully",
                'restored_count' => $restoredCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore customers: ' . $e->getMessage(),
            ], 500);
        }
    }
}
