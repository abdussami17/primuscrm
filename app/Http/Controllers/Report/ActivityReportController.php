<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityReportExport;
use Illuminate\Support\Facades\Log;

class ActivityReportController extends Controller
{
    public function activityReportShow()
    {
        $assignedBy = User::where('is_active', true)->select('name', 'id')->get();
        $activityTypes = Activity::select('type')->distinct()->orderBy('type')->pluck('type');
        $showroomVisit = ['in_progress' => 'In Progress', 'completed' => 'Completed'];
        $salesManagers = User::where('is_active', true)->whereHas('roles', fn($q) => $q->where('name', 'Sales Manager'))->orderBy('name')->get();
        return view('reports.activity-report', compact('salesManagers', 'assignedBy', 'activityTypes', 'showroomVisit'));
    }



    public function fetch(Request $request)
    {
        try {
            $filters = $request->validate([
                'from' => 'nullable|date',
                'to' => 'nullable|date',
                'assigned_to' => 'nullable|array',
                'assigned_to.*' => 'integer',
                'assigned_by' => 'nullable|array',
                'assigned_by.*' => 'integer',
                'activity_type' => 'nullable|array',
                'activity_type.*' => 'string',
                'lead_type' => 'nullable|array',
                'lead_type.*' => 'string',
                'source' => 'nullable|array',
                'source.*' => 'string',
                'lead_status' => 'nullable|array',
                'lead_status.*' => 'string',
                'showroom_visit' => 'nullable|array',
                'showroom_visit.*' => 'string',
            ]);

            $activities = Activity::query()
                ->addSelect([
                    'visit_duration' => \DB::table('showroom_visits')->select('duration')->whereColumn('deal_id', 'activities.deal_id')->whereColumn('customer_id', 'activities.customer_id')->latest()->limit(1),
                ])
                ->with(['customer', 'user', 'deal'])
                // Filter by date
                ->when($filters['from'] ?? null, fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
                ->when($filters['to'] ?? null, fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
                // Assigned To (deal.sales_person_id)
                ->when($filters['assigned_to'] ?? null, function ($q) use ($filters) {
                    $q->whereHas('deal', function ($q2) use ($filters) {
                        $q2->whereIn('sales_person_id', $filters['assigned_to']);
                    });
                })

                // Assigned By (activity.user_id)
                ->when($filters['assigned_by'] ?? null, fn($q) => $q->whereIn('user_id', $filters['assigned_by']))
                // Activity type
                ->when($filters['activity_type'] ?? null, fn($q) => $q->whereIn('type', $filters['activity_type']))
                // Lead type
                ->when($filters['lead_type'] ?? null, fn($q) => $q->whereHas('deal', fn($q2) => $q2->whereIn('lead_type', $filters['lead_type'])))
                // Source
                ->when($filters['source'] ?? null, fn($q) => $q->whereHas('customer', fn($q2) => $q2->whereIn('lead_source', $filters['source'])))
                // Status
                ->when($filters['lead_status'] ?? null, function ($q) use ($filters) {
                    $statuses = array_map('strtolower', $filters['lead_status']);
                    $q->whereHas('deal', function ($q2) use ($statuses) {
                        $q2->whereIn(\DB::raw('LOWER(status)'), $statuses);
                    });
                })
                // Showroom visit filter (custom join)
                ->when($filters['showroom_visit'] ?? null, function ($q) use ($filters) {
                    $q->whereExists(function ($query) use ($filters) {
                        $query->selectRaw('1')->from('showroom_visits')->whereColumn('showroom_visits.deal_id', 'activities.deal_id')->whereColumn('showroom_visits.customer_id', 'activities.customer_id')->whereIn('showroom_visits.status', $filters['showroom_visit'])->limit(1);
                    });
                })
                ->latest()
                ->get()
                ->map(function ($activity) {
                    $meta = $activity->metadata ?? [];
                    return [
                        'full_name' => trim(($activity->customer->first_name ?? '') . ' ' . ($activity->customer->last_name ?? '')) ?: 'N/A',
                        'assigned_to' => $activity->deal->salesPerson->name ?? 'N/A',
                        'assigned_by' => $activity->user->name ?? 'N/A',
                        'source' => $activity->customer->lead_source ?? 'N/A',
                        'lead_type' => $activity->deal->lead_type ?? 'N/A',
                        'vehicle_interest' => $meta['vehicle_of_interest'] ?? ($activity->deal->vehicle_description ?? 'N/A'),
<<<<<<< HEAD
                        'trade_in_vehicle' => $meta['trade_in_vehicle'] ?? trim(
                            ($activity->deal->tradeIn->year ?? '') . ' ' .
                            ($activity->deal->tradeIn->make ?? '') . ' ' .
                            ($activity->deal->tradeIn->model ?? '')
                        ) ?: 'N/A',
=======
                        'trade_in_vehicle' => $meta['trade_in_vehicle'] ?? ($activity->deal->trade_in ?? 'N/A'),
>>>>>>> 2c2262bd2e44b91ac79d76b1f44bd9e5dba4bdb6
                        'activity_type' => $activity->type ?? 'N/A',
                        'activity_datetime' => optional($activity->created_at)->format('M d, Y h:i A') ?? 'N/A',
                        'status_type' => $activity->deal->status ?? 'N/A',
                        'notes_preview' => $activity->description ?? 'N/A',
                        'duration' => $activity->visit_duration ?? 'N/A',
                    ];
                });

            return response()->json([
                'success' => true,
                'count' => $activities->count(),
                'data' => $activities,
            ]);
        } catch (\Throwable $e) {
            Log::error('Activity Report Error', ['message' => $e->getMessage()]);
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to load activities',
                ],
                500,
            );
        }
    }


    private function queryActivities(array $filters)
{
    return Activity::query()

        ->addSelect([
            'visit_duration' => \DB::table('showroom_visits')
                ->select('duration')
                ->whereColumn('deal_id', 'activities.deal_id')
                ->whereColumn('customer_id', 'activities.customer_id')
                ->latest()
                ->limit(1)
        ])

        ->with(['customer','user','deal.salesPerson'])

        ->when($filters['from'] ?? null,
            fn($q) => $q->whereDate('created_at','>=',$filters['from'])
        )

        ->when($filters['to'] ?? null,
            fn($q) => $q->whereDate('created_at','<=',$filters['to'])
        )

        ->when($filters['assigned_to'] ?? null,
            fn($q) => $q->whereHas('deal',
                fn($q2) => $q2->whereIn('sales_person_id',$filters['assigned_to'])
            )
        )

        ->when($filters['assigned_by'] ?? null,
            fn($q) => $q->whereIn('user_id',$filters['assigned_by'])
        )

        ->when($filters['activity_type'] ?? null,
            fn($q) => $q->whereIn('type',$filters['activity_type'])
        )

        ->when($filters['lead_type'] ?? null,
            fn($q) => $q->whereHas('deal',
                fn($q2) => $q2->whereIn('lead_type',$filters['lead_type'])
            )
        )

        ->when($filters['source'] ?? null,
            fn($q) => $q->whereHas('customer',
                fn($q2) => $q2->whereIn('lead_source',$filters['source'])
            )
        )

        ->when($filters['lead_status'] ?? null,
            fn($q) => $q->whereHas('deal',
                fn($q2) => $q2->whereIn('status',$filters['lead_status'])
            )
        )

        ->when($filters['showroom_visit'] ?? null,
            fn($q) => $q->whereExists(function ($query) use ($filters) {
                $query->selectRaw('1')
                    ->from('showroom_visits')
                    ->whereColumn('deal_id','activities.deal_id')
                    ->whereColumn('customer_id','activities.customer_id')
                    ->whereIn('status',$filters['showroom_visit']);
            })
        )

        ->latest();
}

private function validateFilters(Request $request): array
{
    return $request->validate([
        'from' => 'nullable|date',
        'to' => 'nullable|date',

        'assigned_to' => 'nullable|array',
        'assigned_to.*' => 'integer',

        'assigned_by' => 'nullable|array',
        'assigned_by.*' => 'integer',

        'activity_type' => 'nullable|array',
        'activity_type.*' => 'string',

        'lead_type' => 'nullable|array',
        'lead_type.*' => 'string',

        'source' => 'nullable|array',
        'source.*' => 'string',

        'lead_status' => 'nullable|array',
        'lead_status.*' => 'string',

        'showroom_visit' => 'nullable|array',
        'showroom_visit.*' => 'string',
    ]);
}
private function na($value)
{
    return filled($value) ? $value : 'N/A';
}
public function export(Request $request)
{
    $filters = $this->validateFilters($request);

    $rows = $this->queryActivities($filters)
    ->get()
    ->map(function ($activity) {

        $meta = $activity->metadata ?? [];

        return [
            $this->na(trim(($activity->customer->first_name ?? '') . ' ' . ($activity->customer->last_name ?? ''))),

            $this->na($activity->deal->salesPerson->name ?? null),

            $this->na($activity->user->name ?? null),

            $this->na($activity->customer->lead_source ?? null),

            $this->na($activity->deal->lead_type ?? null),

            $this->na($meta['vehicle_of_interest'] ?? $activity->deal->vehicle_description ?? null),

            $this->na($meta['trade_in_vehicle'] ?? $activity->deal->trade_in ?? null),

            $this->na($activity->type ?? null),

            $this->na(optional($activity->created_at)->format('M d, Y h:i A')),

            $this->na($activity->deal->status ?? null),

            $this->na($activity->description ?? null),

            $this->na($activity->visit_duration ?? null),
        ];
    });

    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\ActivityReportExport($rows),
        'activity-report.xlsx'
    );
}
}
