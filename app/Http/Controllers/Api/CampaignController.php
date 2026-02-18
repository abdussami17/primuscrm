<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $q = Campaign::query();
    
        return response()->json(['data' => $q->latest()->paginate(20)]);
    }

    public function show(Campaign $campaign)
    {
        return response()->json(['data' => $campaign]);
    }

    /**
     * Return recipients/customers associated with a campaign.
     * If campaign->recipients contains customer IDs or emails, we'll resolve them.
     */
    public function recipients(Campaign $campaign, Request $request)
    {
        $status = $request->query('status');

        $recipients = $campaign->recipients ?? [];
        $ids = [];
        $emails = [];

        foreach ((array) $recipients as $r) {
            if (is_numeric($r)) $ids[] = (int) $r;
            elseif (is_array($r) && isset($r['id'])) $ids[] = (int) $r['id'];
            elseif (is_string($r) && filter_var($r, FILTER_VALIDATE_EMAIL)) $emails[] = $r;
        }

        $customersQuery = \App\Models\Customer::query();
        if ($ids) $customersQuery->whereIn('id', $ids);
        if ($emails) $customersQuery->orWhereIn('email', $emails);

        $customers = $customersQuery->get();

        return response()->json(['data' => $customers]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'name','template_id','template_name','sender_type','sender','backup_sender','language',
            'subject','body','start_at','end_at','set_type','drip_initial_count','drip_days','recipients'
        ]);

        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'template_id' => 'nullable|integer',
            'template_name' => 'nullable|string|max:255',
            'sender_type' => 'nullable|string|max:50',
            'sender' => 'nullable|integer',
            'backup_sender' => 'nullable|integer',
            'language' => 'nullable|string|max:10',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
            'set_type' => 'nullable|string',
            'drip_initial_count' => 'nullable|integer',
            'drip_days' => 'nullable|integer',
            'recipients' => 'nullable'
        ]);

        if ($validator->fails()) return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);


        // Ensure integer fields are cast
        $data['template_id'] = isset($data['template_id']) && is_numeric($data['template_id']) ? (int)$data['template_id'] : null;
        $data['sender'] = isset($data['sender']) && is_numeric($data['sender']) ? (int)$data['sender'] : null;
        $data['backup_sender'] = isset($data['backup_sender']) && is_numeric($data['backup_sender']) ? (int)$data['backup_sender'] : null;
        $data['drip_initial_count'] = isset($data['drip_initial_count']) && is_numeric($data['drip_initial_count']) ? (int)$data['drip_initial_count'] : null;
        $data['drip_days'] = isset($data['drip_days']) && is_numeric($data['drip_days']) ? (int)$data['drip_days'] : null;

        // If template_name is missing but template_id is provided, try to resolve the name server-side
        if (empty($data['template_name']) && !empty($data['template_id'])) {
            try {
                $template = \App\Models\Template::find($data['template_id']);
                if ($template) {
                    $data['template_name'] = $template->name ?? ($template->template_name ?? null);
                }
            } catch (\Throwable $e) {
                // ignore resolution failures
            }
        }

        // If recipients is a JSON string, try to decode it
        if (isset($data['recipients']) && is_string($data['recipients'])) {
            $decoded = json_decode($data['recipients'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $data['recipients'] = $decoded;
            }
        }

        try {
            $campaign = Campaign::create(array_merge($data, ['created_by' => $request->user()->id ?? null]));
        } catch (\Throwable $e) {
            logger()->error('Campaign create failed', ['error' => $e->getMessage(), 'data' => $data]);
            return response()->json(['message' => 'Failed to create campaign', 'error' => $e->getMessage()], 500);
        }

        // Dispatch send job: immediate or scheduled based on start_at
        $dispatched = true;
        try {
            if (!empty($campaign->start_at)) {
                $start = \Illuminate\Support\Carbon::parse($campaign->start_at);
                if ($start->isFuture()) {
                    \App\Jobs\SendCampaignJob::dispatch($campaign)->delay($start);
                } else {
                    \App\Jobs\SendCampaignJob::dispatch($campaign);
                }
            } else {
                // default: dispatch immediately
                \App\Jobs\SendCampaignJob::dispatch($campaign);
            }
        } catch (\Throwable $e) {
            $dispatched = false;
            logger()->error('Failed to dispatch campaign send job', ['campaign_id' => $campaign->id, 'error' => $e->getMessage()]);
        }

        $message = $dispatched ? 'Campaign created and dispatch scheduled' : 'Campaign created but failed to dispatch send job';
        return response()->json(['message' => $message, 'data' => $campaign], 201);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->only(['name','subject','body','start_at','end_at','set_type','drip_initial_count','drip_days','recipients']);
        $campaign->update($data);
        return response()->json(['message' => 'Campaign updated', 'data' => $campaign]);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->json(['message' => 'Campaign deleted']);
    }
}
