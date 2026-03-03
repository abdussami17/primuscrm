<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::latest()->paginate(20);

        // Enrich each campaign with creator name and real metrics
        $campaigns->getCollection()->transform(function (Campaign $c) {
            // Resolve creator name
            $creator = null;
            if ($c->created_by) {
                $creator = \App\Models\User::find($c->created_by);
            }
            $c->created_by_name = $creator ? $creator->name : null;

            // Resolve recipients — track who has an email vs. not
            $recipients = $c->recipients ?? [];
            if (!is_array($recipients)) {
                try { $recipients = json_decode($recipients, true) ?: []; } catch (\Throwable $e) { $recipients = []; }
            }

            $ids    = [];
            $emails = [];
            foreach ($recipients as $r) {
                if (is_numeric($r))                                    $ids[]    = (int) $r;
                elseif (is_array($r) && isset($r['id']))               $ids[]    = (int) $r['id'];
                elseif (is_string($r) && filter_var($r, FILTER_VALIDATE_EMAIL)) $emails[] = $r;
            }

            $customers = collect();
            if ($ids || $emails) {
                $q = \App\Models\Customer::query();
                if ($ids)    $q->whereIn('id', $ids);
                if ($emails) $q->orWhereIn('email', $emails);
                $customers = $q->get();
            }

            $totalRecipients = $customers->count() + count($emails);
            // "sent" = campaign has been dispatched (status sent/sending)
            $sent = in_array($c->status, ['sent', 'sending']) ? $totalRecipients : 0;
            // customers with no email = excluded/bounced proxy
            $noEmail = $customers->whereNull('email')->count()
                     + $customers->where('email', '')->count();

            $c->metrics = [
                'sent'         => $sent,
                'bounced'      => $noEmail,
                'appointments' => 0,   // no tracking table yet
                'unsubscribed' => 0,
                'delivered'    => max(0, $sent - $noEmail),
                'opened'       => 0,
                'clicked'      => 0,
                'replied'      => 0,
            ];

            $c->recipients_resolved_count = $totalRecipients;

            return $c;
        });

        return response()->json(['data' => $campaigns]);
    }

    public function show(Campaign $campaign)
    {
        return response()->json(['data' => $campaign]);
    }

    /**
     * Return recipients/customers associated with a campaign with full profile fields.
     */
    public function recipients(Campaign $campaign, Request $request)
    {
        $recipients = $campaign->recipients ?? [];
        if (!is_array($recipients)) {
            try { $recipients = json_decode($recipients, true) ?: []; } catch (\Throwable $e) { $recipients = []; }
        }

        $ids    = [];
        $emails = [];
        foreach ((array) $recipients as $r) {
            if (is_numeric($r))                                             $ids[]    = (int) $r;
            elseif (is_array($r) && isset($r['id']))                        $ids[]    = (int) $r['id'];
            elseif (is_string($r) && filter_var($r, FILTER_VALIDATE_EMAIL)) $emails[] = $r;
        }

        $customers = collect();
        if ($ids || $emails) {
            $q = \App\Models\Customer::with(['assignedUser', 'secondaryAssignedUser']);
            if ($ids)    $q->whereIn('id', $ids);
            if ($emails) $q->orWhereIn('email', $emails);
            $customers = $q->get();
        }

        $data = $customers->map(function ($c) use ($campaign) {
            return [
                'id'                => $c->id,
                'name'              => $c->full_name ?? trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? '')),
                'first_name'        => $c->first_name,
                'last_name'         => $c->last_name,
                'email'             => $c->email,
                'cell_phone'        => $c->cell_phone,
                'phone'             => $c->phone,
                'work_phone'        => $c->work_phone,
                'city'              => $c->city,
                'state'             => $c->state,
                'assigned_to'       => $c->assignedUser->name ?? null,
                'assigned_by'       => $c->assigned_by ?? null,
                'lead_type'         => $c->lead_type ?? null,
                'deal_type'         => $c->deal_type ?? null,
                'lead_status'       => $c->status ?? null,
                'sales_status'      => $c->sales_status ?? null,
                'source'            => $c->lead_source ?? null,
                'inventory_type'    => $c->inventory_type ?? null,
                'sales_type'        => $c->sales_type ?? null,
                'created_by'        => $c->created_by ?? null,
                'created_at'        => $c->created_at ? $c->created_at->toDateTimeString() : null,
                'vehicle'           => trim(implode(' ', array_filter([
                    $c->interested_year ?? null,
                    $c->interested_make ?? null,
                    $c->interested_model ?? null,
                ]))),
                // Status-specific dates — populated when tracking is added
                'sent'              => in_array($campaign->status, ['sent','sending']) ? ($campaign->last_sent_at?->toDateTimeString() ?? $campaign->updated_at?->toDateTimeString()) : null,
                'delivered'         => in_array($campaign->status, ['sent','sending']) && $c->email ? ($campaign->last_sent_at?->toDateTimeString() ?? $campaign->updated_at?->toDateTimeString()) : null,
                'bounced'           => (!$c->email) ? $campaign->updated_at?->toDateTimeString() : null,
                'opened'            => null,
                'clicked'           => null,
                'replied'           => null,
                'appointments'      => null,
                'unsubscribed'      => null,
            ];
        });

        return response()->json(['data' => $data]);
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
            // Always save as 'scheduled' — ProcessCampaigns handles sending via the JS poll
            $recipientsCount = is_array($data['recipients'] ?? null) ? count($data['recipients']) : 0;
            $campaign = Campaign::create(array_merge($data, [
                'created_by'       => auth()->id() ?? ($request->user()->id ?? null),
                'status'           => 'scheduled',
                'recipients_count' => $recipientsCount,
            ]));
        } catch (\Throwable $e) {
            logger()->error('Campaign create failed', ['error' => $e->getMessage(), 'data' => $data]);
            return response()->json(['message' => 'Failed to create campaign', 'error' => $e->getMessage()], 500);
        }

        // Immediately try to process — if start_at is past/null it will send right away
        try {
            \Illuminate\Support\Facades\Artisan::call('campaigns:process');
        } catch (\Throwable $e) {
            logger()->error('Auto-process after store failed', ['campaign_id' => $campaign->id, 'error' => $e->getMessage()]);
        }

        $campaign->refresh();
        return response()->json(['message' => 'Campaign created', 'data' => $campaign], 201);
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

    /**
     * Trigger campaign processing (called by the JS background poll).
     * Runs the campaigns:process artisan command and returns a JSON count.
     */
    public function process(Request $request)
    {
        try {
            $exitCode = Artisan::call('campaigns:process');
            $output   = Artisan::output();

            // Parse how many were dispatched from the command output
            preg_match('/(\d+)\s+campaign/', $output, $m);
            $dispatched = isset($m[1]) ? (int) $m[1] : 0;

            return response()->json([
                'success'    => $exitCode === 0,
                'dispatched' => $dispatched,
                'output'     => trim($output),
            ]);
        } catch (\Throwable $e) {
            logger()->error('Campaign process endpoint failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'dispatched' => 0, 'error' => $e->getMessage()], 500);
        }
    }
}
