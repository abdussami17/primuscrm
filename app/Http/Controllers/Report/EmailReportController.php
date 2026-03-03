<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailReportController extends Controller
{
    public function emailReportShow(){
        $users = User::query()
        ->where('is_active', 1)
        ->orderBy('name')
        ->get(['id', 'name']);

    return view('reports.email-sent-received-report', compact('users'));
    }



    public function fetch(Request $request)
    {
        try {
            $filters = $request->validate([
                'from' => 'nullable|date',
                'to' => 'nullable|date',
                'email_type' => 'nullable|array',
                'email_type.*' => 'string',
                'sent_by' => 'nullable|array',
                'sent_by.*' => 'integer',
              
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
                        'trade_in_vehicle' => $meta['trade_in_vehicle'] ?? trim(
                            ($activity->deal->tradeIn->year ?? '') . ' ' .
                            ($activity->deal->tradeIn->make ?? '') . ' ' .
                            ($activity->deal->tradeIn->model ?? '')
                        ) ?: 'N/A',
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
}
