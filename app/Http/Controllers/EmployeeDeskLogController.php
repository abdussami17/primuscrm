<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deal;
use App\Models\User;
use App\Models\FlagDefinition;
use Illuminate\Http\Request;

class EmployeeDeskLogController extends Controller
{
    public function employeeDeskLog(Request $request)
    {
        // Handle date presets
        $this->applyDatePreset($request);

        // Build query with eager loading
        $query = Deal::with(['customer', 'inventory', 'salesPerson', 'salesManager', 'financeManager', 'showroomVisits']);

        // Apply filters
        $this->applyFilters($query, $request);

        // Get filtered deals
        $deals = $query->orderBy('created_at', 'desc')->get();

        // Process deals for display
        $deals = $deals->map(function ($deal) {
            $deal->lead_contacted_within = $this->calculateTimeSinceCreation($deal->created_at);
            $deal->inventory_type_code = $this->getInventoryTypeCode($deal->inventory_type);
            $deal->status_class = $this->getStatusClass($deal->status);
            $deal->credit_display = $this->getCreditScoreDisplay($deal->customer->credit_score ?? null);
            return $deal;
        });
        
        // Collect all visit IDs
        $visitIds = $deals->pluck('showroomVisits')
            ->flatten()
            ->pluck('id')
            ->filter()
            ->values();

        // Get all notes related to those visits
        $visitNotes = \App\Models\Note::whereIn('metadata->visit_id', $visitIds)
            ->get()
            ->groupBy('metadata.visit_id');

        // Attach notes to each visit
        foreach ($deals as $deal) {
            foreach ($deal->showroomVisits as $visit) {
                $visit->related_notes = $visitNotes[$visit->id] ?? collect();
            }
        }

        // Get filter options
        $users = User::orderBy('name')->get();

        $filterOptions = $this->getFilterOptions();

        // Load flag definitions
        $flagDefinitions = FlagDefinition::where('active', true)->orderBy('order')->get();

        return view('desk_log.employee', array_merge(
            compact('deals', 'users', 'flagDefinitions'),
            $filterOptions,
            ['filters' => $request->all()]
        ));
    }

    /**
     * Apply date preset to request
     */
    private function applyDatePreset(Request $request)
    {
        if (!$request->has('preset')) return;

        $today = Carbon::today();
        $preset = $request->preset;

        switch ($preset) {
            case 'today':
                $request->merge([
                    'from_date' => $today->format('Y-m-d'),
                    'to_date' => $today->format('Y-m-d')
                ]);
                break;
            case 'yesterday':
                $yesterday = $today->copy()->subDay();
                $request->merge([
                    'from_date' => $yesterday->format('Y-m-d'),
                    'to_date' => $yesterday->format('Y-m-d')
                ]);
                break;
            case 'last7Days':
                $request->merge([
                    'from_date' => $today->copy()->subDays(6)->format('Y-m-d'),
                    'to_date' => $today->format('Y-m-d')
                ]);
                break;
            case 'thisWeek':
                $request->merge([
                    'from_date' => $today->copy()->startOfWeek()->format('Y-m-d'),
                    'to_date' => $today->copy()->endOfWeek()->format('Y-m-d')
                ]);
                break;
            case 'lastWeek':
                $request->merge([
                    'from_date' => $today->copy()->subWeek()->startOfWeek()->format('Y-m-d'),
                    'to_date' => $today->copy()->subWeek()->endOfWeek()->format('Y-m-d')
                ]);
                break;
            case 'mtd':
                $request->merge([
                    'from_date' => $today->copy()->startOfMonth()->format('Y-m-d'),
                    'to_date' => $today->format('Y-m-d')
                ]);
                break;
            case 'lastMonth':
                $request->merge([
                    'from_date' => $today->copy()->subMonth()->startOfMonth()->format('Y-m-d'),
                    'to_date' => $today->copy()->subMonth()->endOfMonth()->format('Y-m-d')
                ]);
                break;
            case 'ytd':
                $request->merge([
                    'from_date' => $today->copy()->startOfYear()->format('Y-m-d'),
                    'to_date' => $today->format('Y-m-d')
                ]);
                break;
        }
    }

    /**
     * Apply all filters to query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        if ($request->filled('user_id')) {
            $query->where('sales_person_id', $request->user_id);
        }
        if ($request->filled('team')) {
            $query->whereHas('salesPerson', function ($q) use ($request) {
                $q->where('role', $request->team);
            });
        }
        if ($request->filled('lead_type')) {
            $query->where('lead_type', $request->lead_type);
        }
        if ($request->filled('lead_status')) {
            $query->where('status', $request->lead_status);
        }
        if ($request->filled('source')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('source', $request->source);
            });
        }
        if ($request->filled('inventory_type')) {
            $query->where('inventory_type', $request->inventory_type);
        }
        if ($request->filled('sales_status')) {
            $query->where('status', $request->sales_status);
        }
        if ($request->filled('deal_type')) {
            $query->where('deal_type', $request->deal_type);
        }
        if ($request->filled('dealership')) {
            $query->where('dealership_id', $request->dealership);
        }
    }

    /**
     * Get all filter options
     */
    private function getFilterOptions()
    {
        return [
            'teams' => [
                'sales-rep' => 'Sales Rep',
                'bdc-agent' => 'BDC Agent',
                'fi' => 'F&I',
                'sales-manager' => 'Sales Manager',
                'bdc-manager' => 'BDC Manager',
                'finance-director' => 'Finance Director',
                'general-sales-manager' => 'General Sales Manager',
                'general-manager' => 'General Manager',
                'dealer-principal' => 'Dealer Principal',
                'admin' => 'Admin',
                'reception' => 'Reception',
                'service-advisor' => 'Service Advisor',
                'service-manager' => 'Service Manager',
                'inventory-manager' => 'Inventory Manager',
                'fixed-operations-manager' => 'Fixed Operations Manager',
            ],
            'leadTypes' => ['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Import', 'Wholesale', 'Lease Renewal'],
            'leadStatuses' => ['Active', 'Duplicate', 'Invalid', 'Lost', 'Sold', 'Wishlist'],
            'sources' => ['Walk-In', 'Phone Up', 'Text', 'Repeat Customer', 'Referral', 'Service to Sales', 'Lease Renewal', 'Drive By', 'Dealer Website'],
            'inventoryTypes' => ['New', 'Pre-Owned', 'CPO', 'Demo', 'Wholesale', 'Unknown'],
            'salesStatuses' => ['Uncontacted', 'Attempted', 'Contacted', 'Dealer Visit', 'Demo', 'Write-Up', 'Pending F&I', 'Sold', 'Delivered', 'Lost'],
            'dealTypes' => ['Finance', 'Lease', 'Cash', 'Unknown'],
            'dealerships' => [
                ['id' => 1, 'name' => '#18874 Bannister GM Vernon'],
                ['id' => 2, 'name' => 'Twin Motors Thompson'],
                ['id' => 3, 'name' => '#19234 Bannister Ford'],
                ['id' => 4, 'name' => '#19345 Bannister Nissan'],

               
            ],
            'salesTypes' => ['Sales','Service','Parts'],
            'statusTypes' => ['Open','Completed','Missed','Cancelled','No Response','No Show'],
            'taskTypes' => ['Inbound Call','Outbound Call','Inbound Text','Outbound Text','Inbound Email','Outbound Email','CSI','Appointments','Other'],
        ];
    }

    private function calculateTimeSinceCreation($createdAt)
    {
        if (!$createdAt) return 'N/A';
        $diff = Carbon::now()->diff($createdAt);
        if ($diff->days > 0) {
            return $diff->days . 'd ' . $diff->h . 'h';
        }
        return $diff->h . 'h ' . $diff->i . 'm';
    }

    private function getInventoryTypeCode($type)
    {
        $codes = ['New' => 'N', 'Pre-Owned' => 'U', 'CPO' => 'CPO', 'Demo' => 'D', 'Wholesale' => 'W'];
        return $codes[$type] ?? '?';
    }

    private function getStatusClass($status)
    {
        return match (strtolower($status ?? '')) {
            'sold', 'delivered' => 'text-success',
            'lost' => 'text-danger',
            'active', 'contacted' => 'text-primary',
            default => 'text-muted'
        };
    }

    private function getCreditScoreDisplay($score)
    {
        if (!$score) return '';
        $emoji = $score >= 700 ? '🔥 ' : ($score >= 600 ? '⚡ ' : '');
        return $emoji . $score;
    }

    /**
     * Update deal date (sold/delivered)
     */
    public function updateDate(Request $request)
    {
        $request->validate([
            'deal_id' => 'required|exists:deals,id',
            'date_type' => 'required|in:sold_date,delivery_date',
            'date' => 'required|date'
        ]);

        $deal = Deal::findOrFail($request->deal_id);
        $deal->{$request->date_type} = $request->date;
        $deal->save();

        return back()->with('success', ucfirst(str_replace('_', ' ', $request->date_type)) . ' updated successfully');
    }
}
