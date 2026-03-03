<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deal;
use App\Models\Task;
use App\Models\Customer;
use App\Models\ShowroomVisit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard view.
     */
    public function index()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();
        return view('dashboard.index', compact('users'));
    }

    // =========================================================
    //  HELPER: apply date range to a query builder
    // =========================================================
    private function applyDateRange($query, $period, string $column = 'created_at')
    {
        $now   = Carbon::now();
        switch ($period) {
            case 'today':
                $query->whereDate($column, $now->toDateString());
                break;
            case 'yesterday':
                $query->whereDate($column, $now->subDay()->toDateString());
                break;
            case 'last7':
                $query->where($column, '>=', Carbon::now()->subDays(7));
                break;
            case 'thisMonth':
                $query->whereMonth($column, $now->month)->whereYear($column, $now->year);
                break;
            case 'lastMonth':
                $lm = $now->subMonth();
                $query->whereMonth($column, $lm->month)->whereYear($column, $lm->year);
                break;
            default:
                // "all" or unknown - no filter; you can also add custom range handling
        }
        return $query;
    }

    // =========================================================
    //  HELPER: build a standard customer/deal row array
    // =========================================================
    private function buildCustomerRow(Customer $customer, ?Deal $deal = null): array
    {
        $assignedUser   = $customer->assignedUser;
        $assignedManager= optional($customer->assignedManagerUser);
        $vehicle        = $deal ? ($deal->vehicle ?? null) : null;

        return [
            'customer_id'    => $customer->id,
            'customerName'   => $customer->first_name . ' ' . $customer->last_name,
            'assignedTo'     => $assignedUser ? $assignedUser->name : '—',
            'assignedBy'     => $assignedManager ? $assignedManager->name : '—',
            'createdBy'      => '—',
            'email'          => $customer->email ?? '—',
            'cellNumber'     => $customer->cell_phone ?? '—',
            'homeNumber'     => $customer->phone ?? '—',
            'workNumber'     => $customer->work_phone ?? '—',
            'vehicle'        => $vehicle
                ? trim(($vehicle->year ?? '') . ' ' . ($vehicle->make ?? '') . ' ' . ($vehicle->model ?? ''))
                : ($deal && $deal->vehicle_description ? $deal->vehicle_description : '—'),
            'leadType'       => $deal ? ($deal->lead_type ?? '—') : '—',
            'dealType'       => $deal ? ($deal->deal_type ?? '—') : '—',
            'source'         => $deal ? ($deal->source ?? '—') : ($customer->lead_source ?? '—'),
            'inventoryType'  => $deal ? ($deal->inventory_type ?? '—') : ($customer->inventory_type ?? '—'),
            'salesType'      => '—',
            'leadStatus'     => $customer->status ?? '—',
            'salesStatus'    => $deal ? ($deal->sales_status ?? '—') : '—',
            'createdDate'    => $customer->created_at ? $customer->created_at->format('M d, Y g:i A') : '—',
        ];
    }

    // =========================================================
    //  1.  ALERT BAR STATS
    // =========================================================
    public function alertBarStats()
    {
        $today = Carbon::today();

        // Missed Leads: deals created today with sales_status = 'Uncontacted'
        $missedLeads = Deal::whereDate('deals.created_at', $today)
            ->where('sales_status', 'Uncontacted')
            ->count();

        // Avg Response Time (minutes): avg difference between created_at and last_contacted_at
        $avgMinutes = Customer::whereNotNull('last_contacted_at')
            ->whereDate('created_at', $today)
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, last_contacted_at)) as avg_minutes'))
            ->value('avg_minutes');
        $avgResponse = $avgMinutes ? round($avgMinutes) . 'm' : '—';

        // Tasks Completed %
        $totalTasks     = Task::whereDate('created_at', $today)->count();
        $completedTasks = Task::whereDate('created_at', $today)
            ->where('status_type', 'completed')
            ->count();
        $taskPct = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) . '%' : '0%';

        // Sold Today
        $soldToday = Deal::whereDate('sold_date', $today)
            ->where('status', 'sold')
            ->count();

        return response()->json([
            'missedLeads'   => $missedLeads,
            'avgResponse'   => $avgResponse,
            'tasksPct'      => $taskPct,
            'soldToday'     => $soldToday,
        ]);
    }

    // =========================================================
    //  2.  UNCONTACTED LEADS  (count + hourly chart + list)
    //      Leads = Deals whose customer has not been contacted
    // =========================================================
    public function uncontactedLeads(Request $request)
    {
        $period = $request->get('period', 'today');
        $hour   = $request->get('hour');

        // Uncontacted = Deals where sales_status = 'Uncontacted'
        $count = Deal::where('sales_status', 'Uncontacted')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        // Hourly breakdown
        $hourly = array_fill(0, 24, 0);
        Deal::where('sales_status', 'Uncontacted')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('hour')
            ->get()
            ->each(function ($row) use (&$hourly) {
                $hourly[$row->hour] = (int) $row->cnt;
            });

        // List (optionally filtered by hour)
        $listQ = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->where('sales_status', 'Uncontacted')
            ->tap(fn($q) => $this->applyDateRange($q, $period));

        if ($hour !== null) {
            $listQ->whereRaw('HOUR(created_at) = ?', [(int) $hour]);
        }

        $rows = $listQ->limit(200)->get()->map(fn($d) => $this->buildCustomerRow($d->customer, $d));

        return response()->json([
            'count'  => $count,
            'hourly' => $hourly,
            'rows'   => $rows,
        ]);
    }

    // =========================================================
    //  3.  INTERNET LEADS  (count + hourly + list)
    // =========================================================
    public function internetLeads(Request $request)
    {
        $period = $request->get('period', 'today');
        $hour   = $request->get('hour');

        $count = Deal::where('lead_type', 'LIKE', '%Internet%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        // Hourly
        $hourly = array_fill(0, 24, 0);
        Deal::where('lead_type', 'LIKE', '%Internet%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('hour')
            ->get()
            ->each(fn($r) => $hourly[$r->hour] = (int) $r->cnt);

        // List (optionally filtered by hour)
        $listQ = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->where('lead_type', 'LIKE', '%Internet%')
            ->tap(fn($q) => $this->applyDateRange($q, $period));

        if ($hour !== null) {
            $listQ->whereRaw('HOUR(created_at) = ?', [(int) $hour]);
        }

        $rows = $listQ->limit(200)->get()->map(fn($d) => $this->buildCustomerRow($d->customer, $d));

        return response()->json(['count' => $count, 'hourly' => $hourly, 'rows' => $rows]);
    }

    // =========================================================
    //  4.  WALK-IN LEADS  (count + hourly + list)
    // =========================================================
    public function walkInLeads(Request $request)
    {
        $period = $request->get('period', 'today');
        $hour   = $request->get('hour');

        $count = Deal::where('lead_type', 'LIKE', '%Walk%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        $hourly = array_fill(0, 24, 0);
        Deal::where('lead_type', 'LIKE', '%Walk%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('hour')
            ->get()
            ->each(fn($r) => $hourly[$r->hour] = (int) $r->cnt);

        // List (optionally filtered by hour)
        $listQ = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->where('lead_type', 'LIKE', '%Walk%')
            ->tap(fn($q) => $this->applyDateRange($q, $period));

        if ($hour !== null) {
            $listQ->whereRaw('HOUR(created_at) = ?', [(int) $hour]);
        }

        $rows = $listQ->limit(200)->get()->map(fn($d) => $this->buildCustomerRow($d->customer, $d));

        return response()->json(['count' => $count, 'hourly' => $hourly, 'rows' => $rows]);
    }

    // =========================================================
    //  5.  LEAD TYPES  (bar chart + list per type)
    // =========================================================
    public function leadTypes(Request $request)
    {
        $period = $request->get('period', 'today');
        $type   = $request->get('type');

        // Chart counts grouped by lead_type
        $q = Deal::select('lead_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('lead_type');
        $this->applyDateRange($q, $period);
        $chartData = $q->get()->mapWithKeys(fn($r) => [$r->lead_type ?? 'Unknown' => (int) $r->cnt]);

        $rows = [];
        if ($type) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->where('lead_type', $type)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json(['chart' => $chartData, 'rows' => $rows]);
    }

    // =========================================================
    //  6.  OVERDUE TASKS  (count + grouped by task_type)
    // =========================================================
    public function overdueTasks(Request $request)
    {
        $period = $request->get('period', 'today');
        $type   = $request->get('type');

        $base = Task::where('due_date', '<', Carbon::now())
            ->where('status_type', '!=', 'completed');
        $this->applyDateRange($base, $period, 'due_date');

        $count = $base->count();

        // Grouped counts
        $grouped = Task::where('due_date', '<', Carbon::now())
            ->where('status_type', '!=', 'completed')
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'due_date'))
            ->select('task_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('task_type')
            ->get()
            ->mapWithKeys(fn($r) => [$r->task_type ?? 'Other' => (int) $r->cnt]);

        $rows = [];
        if ($type) {
            $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
                ->where('due_date', '<', Carbon::now())
                ->where('status_type', '!=', 'completed')
                ->where('task_type', $type)
                ->tap(fn($q) => $this->applyDateRange($q, $period, 'due_date'))
                ->limit(200)
                ->get()
                ->map(fn($t) => $this->buildTaskRow($t));
        }

        return response()->json(['count' => $count, 'grouped' => $grouped, 'rows' => $rows]);
    }

    // =========================================================
    //  7.  OPEN TASKS  (count + donut data + list per type)
    // =========================================================
    public function openTasks(Request $request)
    {
        $period = $request->get('period', 'today');
        $type   = $request->get('type');

        $base = Task::where('status_type', 'open')
            ->orWhere('status_type', 'pending');
        $this->applyDateRange($base, $period);
        $count = $base->count();

        $grouped = Task::whereIn('status_type', ['open', 'pending'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('task_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('task_type')
            ->get()
            ->mapWithKeys(fn($r) => [$r->task_type ?? 'Other' => (int) $r->cnt]);

        $rows = [];
        if ($type) {
            $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
                ->whereIn('status_type', ['open', 'pending'])
                ->where('task_type', $type)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($t) => $this->buildTaskRow($t));
        }

        return response()->json(['count' => $count, 'grouped' => $grouped, 'rows' => $rows]);
    }

    // =========================================================
    //  8.  ASSIGNED BY  (bar chart + list per assignee)
    //      Leads = Deals, grouped by customer's assigned_manager
    // =========================================================
    public function assignedBy(Request $request)
    {
        $period = $request->get('period', 'today');
        $userId = $request->get('user_id');

        // Chart: deals grouped by customer's assigned_manager
        $grouped = Deal::join('customers', 'deals.customer_id', '=', 'customers.id')
            ->whereNotNull('customers.assigned_manager')
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'deals.created_at'))
            ->select('customers.assigned_manager', DB::raw('COUNT(*) as cnt'))
            ->groupBy('customers.assigned_manager')
            ->get();

        // Fetch user names for the manager IDs
        $userIds  = $grouped->pluck('assigned_manager')->filter()->toArray();
        $userMap  = User::whereIn('id', $userIds)->pluck('name', 'id');

        $chartData = $grouped->map(fn($r) => [
            'user_id'  => $r->assigned_manager,
            'name'     => $userMap[$r->assigned_manager] ?? 'Unknown',
            'count'    => (int) $r->cnt,
        ]);

        $rows = [];
        if ($userId) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->whereHas('customer', fn($q) => $q->where('assigned_manager', $userId))
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json(['chart' => $chartData, 'rows' => $rows]);
    }

    // =========================================================
    //  9.  APPOINTMENTS / SHOWROOM VISITS  (count + bar chart + list)
    // =========================================================
    public function appointments(Request $request)
    {
        $period = $request->get('period', 'today');
        $status = $request->get('status');

        // Appointments = Tasks where task_type contains 'Appointment'
        $baseWhere = fn($q) => $q->where('task_type', 'LIKE', '%Appointment%');

        $count = Task::tap($baseWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        // Group by status_type (Open, Completed, Missed, Cancelled, No Response, No Show)
        $grouped = Task::tap($baseWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('status_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status_type')
            ->get()
            ->mapWithKeys(fn($r) => [ucfirst($r->status_type ?? 'Unknown') => (int) $r->cnt]);

        $rows = [];
        if ($status) {
            $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
                ->where('task_type', 'LIKE', '%Appointment%')
                ->where('status_type', strtolower($status))
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($t) => $this->buildTaskRow($t));
        }

        return response()->json(['count' => $count, 'grouped' => $grouped, 'rows' => $rows]);
    }

    // =========================================================
    // 10.  PURCHASE TYPES  (bar chart + list)
    // =========================================================
    public function purchaseTypes(Request $request)
    {
        $period = $request->get('period', 'today');
        $type   = $request->get('type');

        $q = Deal::select('deal_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('deal_type');
        $this->applyDateRange($q, $period);
        $chart = $q->get()->mapWithKeys(fn($r) => [$r->deal_type ?? 'Unknown' => (int) $r->cnt]);

        $rows = [];
        if ($type) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->where('deal_type', $type)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json(['chart' => $chart, 'rows' => $rows]);
    }

    // =========================================================
    // 11.  CONTACT RATE  (deals whose customer was contacted / total deals)
    // =========================================================
    public function contactRate(Request $request)
    {
        $period = $request->get('period', 'today');

        $total = Deal::tap(fn($q) => $this->applyDateRange($q, $period))->count();
        $contacted = Deal::whereNotIn('sales_status', ['Uncontacted'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        $pct = $total > 0 ? round(($contacted / $total) * 100) : 0;

        $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->limit(200)
            ->get()
            ->map(function ($d) {
                $row = $this->buildCustomerRow($d->customer, $d);
                $row['contacted'] = $d->sales_status !== 'Uncontacted' ? 'Yes' : 'No';
                return $row;
            });

        return response()->json([
            'percentage' => $pct,
            'contacted'  => $contacted,
            'total'      => $total,
            'rows'       => $rows,
        ]);
    }

    // =========================================================
    // 12.  APPOINTMENTS SHOWED RATE  (tasks with task_type Appointment)
    // =========================================================
    public function appointmentsShowedRate(Request $request)
    {
        $period = $request->get('period', 'today');
        $status = $request->get('status');

        $apptWhere = fn($q) => $q->where('task_type', 'LIKE', '%Appointment%');

        $total = Task::tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        // "Showed" = completed appointment tasks
        $showed = Task::tap($apptWhere)
            ->where('status_type', 'completed')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        $pct = $total > 0 ? round(($showed / $total) * 100) : 0;

        // Group by status_type for the chart
        $grouped = Task::tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('status_type', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status_type')
            ->get()
            ->mapWithKeys(fn($r) => [ucfirst($r->status_type ?? 'Unknown') => (int) $r->cnt]);

        $rows = [];
        if ($status) {
            $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
                ->where('task_type', 'LIKE', '%Appointment%')
                ->where('status_type', strtolower($status))
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($t) => $this->buildTaskRow($t));
        }

        return response()->json([
            'percentage' => $pct,
            'chart'      => $grouped,
            'rows'       => $rows,
        ]);
    }

    // =========================================================
    // 13.  TASK COMPLETION RATE
    // =========================================================
    public function taskCompletionRate(Request $request)
    {
        $period = $request->get('period', 'today');

        $total = Task::tap(fn($q) => $this->applyDateRange($q, $period))->count();
        $completed = Task::where('status_type', 'completed')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        $pct = $total > 0 ? round(($completed / $total) * 100) : 0;

        $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->limit(200)
            ->get()
            ->map(fn($t) => $this->buildTaskRow($t));

        return response()->json([
            'percentage' => $pct,
            'completed'  => $completed,
            'open'       => $total - $completed,
            'rows'       => $rows,
        ]);
    }

    // =========================================================
    // 14.  SPEED-TO-SALE (aggregate metrics)
    // =========================================================
    public function speedToSale(Request $request)
    {
        $period = $request->get('period', 'today');

        // Speed to Lead: avg minutes from customer created_at → last_contacted_at
        $speedToLead = Customer::whereNotNull('last_contacted_at')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, last_contacted_at)) as avg_min'))
            ->value('avg_min');

        // Avg conversion time: avg days from customer created_at → deal sold_date
        $conversionDays = Deal::whereNotNull('deals.sold_date')
            ->where('deals.status', 'sold')
            ->join('customers', 'deals.customer_id', '=', 'customers.id')
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'deals.created_at'))
            ->select(DB::raw('AVG(TIMESTAMPDIFF(DAY, customers.created_at, deals.sold_date)) as avg_days'))
            ->value('avg_days');

        return response()->json([
            'speedToLead'    => $speedToLead ? round($speedToLead) . ' min' : '— min',
            'conversionDays' => $conversionDays ? round($conversionDays, 1) . ' Days' : '— Days',
        ]);
    }

    // =========================================================
    // 15.  FINANCE CONTACT RATE  (finance deals / total deals)
    // =========================================================
    public function financeContactRate(Request $request)
    {
        $period = $request->get('period', 'today');

        $total = Deal::tap(fn($q) => $this->applyDateRange($q, $period))->count();
        $finance = Deal::where('deal_type', 'Finance')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        $pct = $total > 0 ? round(($finance / $total) * 100) : 0;

        $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->limit(200)
            ->get()
            ->map(function ($d) {
                $row = $this->buildCustomerRow($d->customer, $d);
                $row['contacted'] = $d->customer && $d->customer->last_contacted_at ? 'Yes' : 'No';
                return $row;
            });

        return response()->json([
            'percentage' => $pct,
            'finance'    => $finance,
            'total'      => $total,
            'rows'       => $rows,
        ]);
    }

    // =========================================================
    // 15b. LEASE PENETRATION  (lease deals / total deals)
    // =========================================================
    public function leasePenetration(Request $request)
    {
        $period = $request->get('period', 'today');

        $total = Deal::tap(fn($q) => $this->applyDateRange($q, $period))->count();
        $lease = Deal::where('deal_type', 'Lease')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        $pct = $total > 0 ? round(($lease / $total) * 100) : 0;

        $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->limit(200)
            ->get()
            ->map(function ($d) {
                $row = $this->buildCustomerRow($d->customer, $d);
                $row['contacted'] = $d->customer && $d->customer->last_contacted_at ? 'Yes' : 'No';
                return $row;
            });

        return response()->json([
            'percentage' => $pct,
            'lease'      => $lease,
            'total'      => $total,
            'rows'       => $rows,
        ]);
    }

    // =========================================================
    // 16.  STORE VISIT CLOSING RATIO
    // =========================================================
    public function storeVisitClosingRatio(Request $request)
    {
        $period = $request->get('period', 'today');

        $apptWhere = fn($q) => $q->where('task_type', 'LIKE', '%Appointment%');

        $total = Task::tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        // "Closed" = appointment tasks whose customer has a sold deal
        $sold = Task::tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->whereHas('customer.deals', fn($q) => $q->where('status', 'sold'))
            ->count();

        $pct = $total > 0 ? round(($sold / $total) * 100, 1) : 0;

        $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
            ->tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->limit(200)
            ->get()
            ->map(function ($t) {
                $row = $this->buildTaskRow($t);
                $c = $t->customer;
                $deal = $c ? $c->deals->first() : null;
                $row['closed'] = ($deal && $deal->status === 'sold') ? 'Yes' : 'No';
                return $row;
            });

        return response()->json(['percentage' => $pct, 'total' => $total, 'sold' => $sold, 'rows' => $rows]);
    }

    // =========================================================
    // 17.  BEBACK CUSTOMERS  (customers who visited more than once)
    // =========================================================
    public function bebackCustomers(Request $request)
    {
        $period = $request->get('period', 'today');

        $customerIds = ShowroomVisit::select('customer_id')
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'start_time'))
            ->groupBy('customer_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('customer_id');

        $customers = Customer::with(['assignedUser', 'assignedManagerUser', 'deals'])
            ->whereIn('id', $customerIds)
            ->limit(200)
            ->get()
            ->map(fn($c) => $this->buildCustomerRow($c, $c->deals->first()));

        return response()->json(['count' => $customerIds->count(), 'rows' => $customers]);
    }

    // =========================================================
    // 18.  SOLD DEAL SOURCES
    // =========================================================
    public function soldDealSources(Request $request)
    {
        $period = $request->get('period', 'all');
        $source = $request->get('source');

        // Summary: group by deals.source
        $summary = Deal::where('status','like', '%sold%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('source', DB::raw('COUNT(*) as cnt'))
            ->groupBy('source')
            ->get()
            ->map(fn($r) => ['source' => $r->source ?? 'Unknown', 'count' => (int) $r->cnt]);

        $rows = [];
        if ($source) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->where('status', 'like', '%sold%')
                ->where('source', $source)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json(['sources' => $summary, 'rows' => $rows]);
    }

    // =========================================================
    // 19.  PENDING F&I DEALS  (showroom: pending_fi = true)
    // =========================================================
    public function pendingFiDeals(Request $request)
    {
        $period = $request->get('period', 'today');

        $rows = ShowroomVisit::with(['customer', 'deal'])
            ->where('pending_fi', true)
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'start_time'))
            ->orderBy('start_time')
            ->limit(200)
            ->get()
            ->map(fn($v) => [
                'customer'    => $v->customer ? ($v->customer->first_name . ' ' . $v->customer->last_name) : '—',
                'email'       => $v->customer ? ($v->customer->email ?? '—') : '—',
                'cellNumber'  => $v->customer ? ($v->customer->cell_phone ?? '—') : '—',
                'vehicle'     => $v->deal ? ($v->deal->vehicle_description ?? '—') : '—',
                'daysPending' => $v->start_time ? Carbon::parse($v->start_time)->diffInDays(Carbon::now()) : 0,
                'startTime'   => $v->start_time ? Carbon::parse($v->start_time)->format('M d, Y g:i A') : '—',
            ]);

        return response()->json(['count' => $rows->count(), 'rows' => $rows]);
    }

    // =========================================================
    // 20.  STORE VISIT DEALS AGING
    // =========================================================
    public function storeVisitDealsAging(Request $request)
    {
        $period = $request->get('period', 'today');

        $rows = ShowroomVisit::with(['customer', 'deal'])
            ->tap(fn($q) => $this->applyDateRange($q, $period, 'start_time'))
            ->orderBy('start_time')
            ->limit(200)
            ->get()
            ->map(fn($v) => [
                'customer'    => $v->customer ? ($v->customer->first_name . ' ' . $v->customer->last_name) : '—',
                'email'       => $v->customer ? ($v->customer->email ?? '—') : '—',
                'cellNumber'  => $v->customer ? ($v->customer->cell_phone ?? '—') : '—',
                'vehicle'     => $v->deal ? ($v->deal->vehicle_description ?? '—') : '—',
                'daysPending' => $v->start_time ? Carbon::parse($v->start_time)->diffInDays(Carbon::now()) : 0,
                'startTime'   => $v->start_time ? Carbon::parse($v->start_time)->format('M d, Y g:i A') : '—',
                'status'      => $v->status ?? '—',
            ]);

        return response()->json(['count' => $rows->count(), 'rows' => $rows]);
    }

    // =========================================================
    // 21.  SALES FUNNEL  (leads = deals, appointments = tasks)
    // =========================================================
    public function salesFunnel(Request $request)
    {
        $period = $request->get('period', 'today');

        $apptWhere = fn($q) => $q->where('task_type', 'LIKE', '%Appointment%');

        // Total leads (deals)
        $customers = Deal::tap(fn($q) => $this->applyDateRange($q, $period))->count();
        // Contacted leads (deals where sales_status is not Uncontacted)
        $contacted = Deal::whereNotIn('sales_status', ['Uncontacted'])
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        // Appointments set (appointment tasks)
        $apptSet = Task::tap($apptWhere)
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        // Appointments shown (completed appointment tasks)
        $apptShown = Task::tap($apptWhere)
            ->where('status_type', 'completed')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();
        // Sold
        $sold = Deal::where('status', 'sold')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->count();

        return response()->json([
            'customers' => $customers,
            'contacted' => $contacted,
            'apptSet'   => $apptSet,
            'apptShown' => $apptShown,
            'sold'      => $sold,
        ]);
    }

    // =========================================================
    // 22.  INTERNET RESPONSE TIME (bucket breakdown, internet leads only)
    // =========================================================
    public function internetResponseTime(Request $request)
    {
        $period = $request->get('period', 'today');
        $bucket = $request->get('bucket');

        $buckets = [
            '0-5'   => ['min' => 0,   'max' => 5],
            '6-10'  => ['min' => 6,   'max' => 10],
            '11-15' => ['min' => 11,  'max' => 15],
            '16-30' => ['min' => 16,  'max' => 30],
            '31-60' => ['min' => 31,  'max' => 60],
            '61+'   => ['min' => 61,  'max' => 99999],
        ];

        // Only internet leads
        $internetCustomerIds = Deal::where('lead_type', 'LIKE', '%Internet%')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->pluck('customer_id')
            ->unique();

        // If a specific bucket is requested, return row-level data
        if ($bucket !== null) {
            $query = Customer::with(['assignedUser', 'assignedManagerUser', 'deals.vehicle'])
                ->whereIn('id', $internetCustomerIds);

            if ($bucket === 'No Contact') {
                $query->whereNull('last_contacted_at');
            } elseif (isset($buckets[$bucket])) {
                $range = $buckets[$bucket];
                $query->whereNotNull('last_contacted_at')
                      ->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, last_contacted_at) BETWEEN ? AND ?', [$range['min'], $range['max']]);
            }

            $rows = $query->limit(200)->get()->map(function ($c) {
                $deal = $c->deals->first();
                $row  = $this->buildCustomerRow($c, $deal);
                $row['responseTime'] = $c->last_contacted_at
                    ? Carbon::parse($c->created_at)->diffInMinutes(Carbon::parse($c->last_contacted_at)) . ' min'
                    : 'No Contact';
                return $row;
            });

            return response()->json(['buckets' => [], 'rows' => $rows]);
        }

        // Default: return bucket counts only
        $result = [];
        foreach ($buckets as $label => $range) {
            $result[$label] = Customer::whereIn('id', $internetCustomerIds)
                ->whereNotNull('last_contacted_at')
                ->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, last_contacted_at) BETWEEN ? AND ?', [$range['min'], $range['max']])
                ->count();
        }

        $noContact = Customer::whereIn('id', $internetCustomerIds)
            ->whereNull('last_contacted_at')
            ->count();
        $result['No Contact'] = $noContact;

        return response()->json(['buckets' => $result]);
    }

    // =========================================================
    // 23.  LOST REASONS
    // =========================================================
    public function lostReasons(Request $request)
    {
        $period = $request->get('period', 'today');
        $reason = $request->get('reason');

        // Deals lost grouped by the associated LostReason name
        // Assuming deals have a lost_reason field or a relation
        $summary = Deal::where('status', 'lost')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('notes', DB::raw('COUNT(*) as cnt')) // using notes as proxy or use a proper lost_reason column
            ->groupBy('notes')
            ->limit(20)
            ->get()
            ->map(fn($r) => ['reason' => $r->notes ?? 'Unknown', 'count' => (int) $r->cnt]);

        $rows = [];
        if ($reason) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->where('status', 'lost')
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json(['reasons' => $summary, 'rows' => $rows]);
    }

    // =========================================================
    // 24.  TOP REPS  (completed appointment tasks per rep)
    // =========================================================
    public function topReps(Request $request)
    {
        $period = $request->get('period', 'today');
        $repId  = $request->get('rep_id');

        $reps = Task::where('task_type', 'LIKE', '%Appointment%')
            ->where('status_type', 'completed')
            ->whereNotNull('assigned_to')
            ->tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('assigned_to', DB::raw('COUNT(*) as cnt'))
            ->groupBy('assigned_to')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'user_id' => $r->assigned_to,
                'name'    => User::find($r->assigned_to)?->name ?? 'Unknown',
                'count'   => (int) $r->cnt,
            ]);

        $rows = [];
        if ($repId) {
            $rows = Task::with(['customer.assignedUser', 'customer.assignedManagerUser', 'customer.deals', 'assignedUser', 'createdBy'])
                ->where('task_type', 'LIKE', '%Appointment%')
                ->where('status_type', 'completed')
                ->where('assigned_to', $repId)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($t) => $this->buildTaskRow($t));
        }

        return response()->json(['reps' => $reps, 'rows' => $rows]);
    }

    // =========================================================
    // 25.  LAST LOGIN / LAST UPDATE
    // =========================================================
    public function lastLogin()
    {
        $users = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->select('id', 'name', 'email', 'last_login_at', 'updated_at')
            ->limit(50)
            ->get()
            ->map(fn($u) => [
                'name'        => $u->name,
                'email'       => $u->email,
                'lastLogin'   => $u->last_login_at ? Carbon::parse($u->last_login_at)->format('M d, Y g:i A') : 'Never',
                'lastUpdate'  => $u->updated_at ? $u->updated_at->format('M d, Y g:i A') : '—',
            ]);

        return response()->json(['users' => $users]);
    }

    // =========================================================
    // 26.  LEAD FLOW  (deals grouped by sales_status)
    // =========================================================
    public function leadFlow(Request $request)
    {
        $period = $request->get('period', 'today');
        $status = $request->get('status');

        // Group deals by sales_status
        $grouped = Deal::tap(fn($q) => $this->applyDateRange($q, $period))
            ->select('sales_status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('sales_status')
            ->get()
            ->mapWithKeys(fn($r) => [$r->sales_status ?? 'Unknown' => (int) $r->cnt]);

        $rows = [];
        if ($status) {
            $rows = Deal::with(['customer.assignedUser', 'customer.assignedManagerUser', 'vehicle'])
                ->where('sales_status', $status)
                ->tap(fn($q) => $this->applyDateRange($q, $period))
                ->limit(200)
                ->get()
                ->map(fn($d) => $this->buildCustomerRow($d->customer, $d));
        }

        return response()->json([
            'grouped' => $grouped,
            'rows'    => $rows,
        ]);
    }

    // =========================================================
    // 27.  USERS LIST (for dropdowns)
    // =========================================================
    public function usersList()
    {
        $users = User::select('id', 'name')->orderBy('name')->get();
        return response()->json(['users' => $users]);
    }

    // =========================================================
    //  PRIVATE: build a row from a Task
    // =========================================================
    private function buildTaskRow(Task $task): array
    {
        $c = $task->customer;
        $deal = $c ? $c->deals->first() : null;

        // Derive direction from task_type (e.g. "Inbound Call" → "Inbound")
        $type = $task->task_type ?? '';
        $direction = '—';
        if (stripos($type, 'inbound') !== false) {
            $direction = 'Inbound';
        } elseif (stripos($type, 'outbound') !== false) {
            $direction = 'Outbound';
        }

        return [
            'taskType'     => $task->task_type ?? '—',
            'statusType'   => $task->status_type ?? '—',
            'dueDate'      => $task->due_date ? $task->due_date->format('M d, Y g:i A') : '—',
            'customerName' => $c ? ($c->first_name . ' ' . $c->last_name) : '—',
            'assignedTo'   => $task->assignedUser ? $task->assignedUser->name : '—',
            'assignedBy'   => $c && $c->assignedManagerUser ? $c->assignedManagerUser->name : '—',
            'createdBy'    => $task->createdBy ? $task->createdBy->name : '—',
            'email'        => $c ? ($c->email ?? '—') : '—',
            'cellNumber'   => $c ? ($c->cell_phone ?? '—') : '—',
            'homeNumber'   => $c ? ($c->phone ?? '—') : '—',
            'workNumber'   => $c ? ($c->work_phone ?? '—') : '—',
            'vehicle'      => $deal
                ? ($deal->vehicle ? trim(($deal->vehicle->year ?? '') . ' ' . ($deal->vehicle->make ?? '') . ' ' . ($deal->vehicle->model ?? '')) : ($deal->vehicle_description ?? '—'))
                : '—',
            'leadType'     => $deal ? ($deal->lead_type ?? '—') : '—',
            'dealType'     => $deal ? ($deal->deal_type ?? '—') : '—',
            'source'       => $deal ? ($deal->source ?? '—') : ($c ? ($c->lead_source ?? '—') : '—'),
            'inventoryType'=> $deal ? ($deal->inventory_type ?? '—') : '—',
            'salesType'    => '—',
            'leadStatus'   => $c ? ($c->status ?? '—') : '—',
            'salesStatus'  => $deal ? ($deal->sales_status ?? '—') : '—',
            'createdDate'  => $task->created_at ? $task->created_at->format('M d, Y g:i A') : '—',
            'direction'    => $direction,
        ];
    }

    // =========================================================
    //  PRIVATE: build a row from a ShowroomVisit (compatible with _taskRow JS)
    // =========================================================
    private function buildVisitRow(ShowroomVisit $visit): array
    {
        $c    = $visit->customer;
        $deal = $visit->deal ?? ($c ? $c->deals->first() : null);

        return [
            'taskType'     => 'Showroom Visit',
            'statusType'   => $visit->status ?? '—',
            'dueDate'      => $visit->start_time ? $visit->start_time->format('M d, Y g:i A') : '—',
            'customerName' => $c ? ($c->first_name . ' ' . $c->last_name) : '—',
            'assignedTo'   => $visit->user ? $visit->user->name : '—',
            'assignedBy'   => $c && $c->assignedManagerUser ? $c->assignedManagerUser->name : '—',
            'createdBy'    => '—',
            'email'        => $c ? ($c->email ?? '—') : '—',
            'cellNumber'   => $c ? ($c->cell_phone ?? '—') : '—',
            'homeNumber'   => $c ? ($c->phone ?? '—') : '—',
            'workNumber'   => $c ? ($c->work_phone ?? '—') : '—',
            'vehicle'      => $deal
                ? ($deal->vehicle ? trim(($deal->vehicle->year ?? '') . ' ' . ($deal->vehicle->make ?? '') . ' ' . ($deal->vehicle->model ?? '')) : ($deal->vehicle_description ?? '—'))
                : '—',
            'leadType'     => $deal ? ($deal->lead_type ?? '—') : '—',
            'dealType'     => $deal ? ($deal->deal_type ?? '—') : '—',
            'source'       => $deal ? ($deal->source ?? '—') : ($c ? ($c->lead_source ?? '—') : '—'),
            'inventoryType'=> $deal ? ($deal->inventory_type ?? '—') : '—',
            'salesType'    => '—',
            'leadStatus'   => $c ? ($c->status ?? '—') : '—',
            'salesStatus'  => $deal ? ($deal->sales_status ?? '—') : '—',
            'createdDate'  => $visit->created_at ? $visit->created_at->format('M d, Y g:i A') : '—',
        ];
    }
}
