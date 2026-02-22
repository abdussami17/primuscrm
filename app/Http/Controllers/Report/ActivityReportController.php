<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityReportController extends Controller
{
    public function activityReportShow()
    {
        return view('reports.activity-report');
    }

    public function fetch(Request $request)
    {
        try {
            $filters = $request->validate([
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date'],
                'assigned_to' => ['nullable', 'array'],
                'assigned_to.*' => ['integer'],
                'activity_type' => ['nullable', 'array'],
                'activity_type.*' => ['string'],
            ]);

            $activities = Activity::query()
            ->addSelect([
                'visit_duration' => \DB::table('showroom_visits')
                    ->select('duration')
                    ->whereColumn('deal_id', 'activities.deal_id')
                    ->whereColumn('customer_id', 'activities.customer_id')
                    ->latest()
                    ->limit(1)
            ])
                ->with(['customer', 'user', 'deal'])
                ->when($filters['from'] ?? null, fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
                ->when($filters['to'] ?? null, fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
                ->when($filters['assigned_to'] ?? null, fn($q) => $q->whereIn('user_id', $filters['assigned_to']))
                ->when($filters['activity_type'] ?? null, fn($q) => $q->whereIn('type', $filters['activity_type']))
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

                        'trade_in_vehicle' => $meta['trade_in_vehicle'] ?? ($activity->deal->trade_in ?? 'N/A'),

                        'activity_type' => $activity->type ?? 'N/A',

                        'activity_datetime' => optional($activity->created_at) ? $activity->created_at->format('M d, Y h:i A') : 'N/A',

                        'status_type' => $activity->deal->status ?? 'N/A',

                        'notes_preview' => $activity->description ? Str::limit($activity->description, 50) : 'N/A',

                        'duration' => $activity->visit_duration ?? 'N/A',
                    ];
                });

            return response()->json([
                'success' => true,
                'count' => $activities->count(),
                'data' => $activities,
            ]);
        } catch (\Throwable $e) {
            Log::error('Activity Report Error', [
                'message' => $e->getMessage(),
            ]);

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
