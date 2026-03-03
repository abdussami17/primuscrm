<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Template;
use App\Models\TelnyxMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsInboxController extends Controller
{
    /**
     * Normalize a phone number to E.164 format.
     */
    private function normalizePhone(string $number): string
    {
        // Strip everything except digits and leading +
        $cleaned = preg_replace('/[^\d+]/', '', $number);

        // Already in E.164
        if (str_starts_with($cleaned, '+')) {
            return $cleaned;
        }

        // Remove trunk prefix (leading zeros)
        $digits = ltrim($cleaned, '0');

        // If empty after stripping, return original cleaned
        if ($digits === '') {
            return '+' . $cleaned;
        }

        $countryCode = config('services.telnyx.default_country_code', '1');

        // If digits already start with the country code, just prepend +
        if (str_starts_with($digits, $countryCode)) {
            return '+' . $digits;
        }

        // Otherwise prepend + and country code
        return '+' . $countryCode . $digits;
    }

    // ── Inbox ─────────────────────────────────────────────────────────────────

    /**
     * List all SMS conversations (one entry per unique contact / phone number).
     */
    public function inbox(Request $request)
    {
        $filter  = $request->get('filter', 'date_high');
        $search  = $request->get('search');
        $folder  = $request->get('folder', 'inbox');   // inbox | starred | sent | draft | deleted

        // Base query — SMS only; scope changes per folder
        if ($folder === 'deleted') {
            $query = TelnyxMessage::sms()->onlyTrashed()->with('customer');
        } elseif ($folder === 'draft') {
            $query = TelnyxMessage::sms()->draft()->with('customer');
        } else {
            $query = TelnyxMessage::sms()->notDraft()->with('customer');

            if ($folder === 'starred') {
                $query->starred();
            } elseif ($folder === 'sent') {
                $query->outbound();
            } else { // inbox
                $query->inbound();
            }
        }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                  ->orWhere('from', 'like', "%{$search}%")
                  ->orWhere('to', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%");
            });
        }

        // Order
        $query->orderBy('created_at', $filter === 'date_low' ? 'asc' : 'desc');

        $allMessages = $query->get();

        // Group by normalized other-party digits → keeps +1XXXXXXXXXX and XXXXXXXXXX in the same thread
        $threads = $allMessages
            ->groupBy(fn($m) => preg_replace('/\D/', '', $m->other_party ?? ''))
            ->map(fn($group) => $group->first())  // already sorted desc, first = most recent
            ->values();

        // Counts for sidebar
        $counts = $this->getCounts();

        // Customers for compose autocomplete (those with cell_phone)
        $customers = Customer::where(function ($q) {
                $q->whereNotNull('cell_phone')->where('cell_phone', '!=', '')
                  ->orWhereNotNull('phone')->where('phone', '!=', '');
            })
            ->select('id', 'first_name', 'last_name', 'cell_phone', 'phone')
            ->orderBy('first_name')
            ->get()
            ->map(fn($c) => [
                'id'    => $c->id,
                'name'  => trim($c->first_name . ' ' . $c->last_name),
                'phone' => $c->cell_phone ?: $c->phone,
            ]);

        // Text/SMS templates for compose modal
        $smsTemplates = Template::active()->ofType('text')->orderBy('name')->get(['id', 'name', 'body']);

        return view('sms.text-inbox', compact('threads', 'counts', 'customers', 'filter', 'search', 'folder', 'smsTemplates'));
    }

    // ── Thread / Show ────────────────────────────────────────────────────────

    /**
     * Show the full conversation thread with a given phone number.
     */
    public function thread(Request $request, string $phone)
    {
        $decodedPhone = urldecode($phone);
        $normalizedPhone = preg_replace('/\D/', '', $decodedPhone);

        // All SMS messages to/from this phone number (match normalized digits)
        $messages = TelnyxMessage::sms()
            ->where(function ($q) use ($normalizedPhone) {
                $q->whereRaw("REGEXP_REPLACE(`from`, '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"])
                  ->orWhereRaw("REGEXP_REPLACE(`to`,   '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"]);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all inbound messages in this thread as read
        TelnyxMessage::sms()
            ->whereRaw("REGEXP_REPLACE(`from`, '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Try to identify the contact (match against customer phone fields)
        $customer = Customer::where(function ($q) use ($normalizedPhone) {
            $q->whereRaw("REGEXP_REPLACE(cell_phone, '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"])
              ->orWhereRaw("REGEXP_REPLACE(phone, '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"])
              ->orWhereRaw("REGEXP_REPLACE(work_phone, '[^0-9]', '') LIKE ?", ["%{$normalizedPhone}%"]);
        })->first();

        $contactName = $messages->first()?->contact_name
            ?? ($customer ? trim($customer->first_name . ' ' . $customer->last_name) : null)
            ?? $decodedPhone;

        // Counts and starred state for UI
        $counts      = $this->getCounts();
        $isStarred   = $messages->contains('is_starred', true);

        // Customers for compose autocomplete
        $customers = Customer::where(function ($q) {
                $q->whereNotNull('cell_phone')->where('cell_phone', '!=', '')
                  ->orWhereNotNull('phone')->where('phone', '!=', '');
            })
            ->select('id', 'first_name', 'last_name', 'cell_phone', 'phone')
            ->orderBy('first_name')
            ->get()
            ->map(fn($c) => [
                'id'    => $c->id,
                'name'  => trim($c->first_name . ' ' . $c->last_name),
                'phone' => $c->cell_phone ?: $c->phone,
            ]);

        // Text/SMS templates for compose modal
        $smsTemplates = Template::active()->ofType('text')->orderBy('name')->get(['id', 'name', 'body']);

        return view('sms.text-reply', compact(
            'messages', 'decodedPhone', 'contactName', 'customer',
            'counts', 'isStarred', 'customers', 'smsTemplates'
        ));
    }

    // ── Send SMS ─────────────────────────────────────────────────────────────

    /**
     * Send an outbound SMS via Telnyx and persist it.
     */
    public function send(Request $request)
    {
        $request->validate([
            'to'   => 'required|string',
            'body' => 'required|string|max:1600',
        ]);

        $apiKey = config('services.telnyx.api_key');
        $from   = preg_replace('/[\s\-().]+/', '', config('services.telnyx.from_number') ?? '');
        $to     = $this->normalizePhone($request->input('to'));
        $body   = $request->input('body');
        $contactName = $request->input('contact_name');

        // Try to look up customer
        $customerId = null;
        if ($request->filled('customer_id')) {
            $customerId = $request->input('customer_id');
        }

        $simulate = filter_var(config('services.telnyx.allow_simulate', env('TELNYX_ALLOW_SIMULATE', false)), FILTER_VALIDATE_BOOLEAN);

        if (empty($apiKey) || empty($from)) {
            if ($simulate) {
                $msg = TelnyxMessage::create([
                    'telnyx_id'    => 'sim-' . time(),
                    'direction'    => 'outbound',
                    'type'         => 'sms',
                    'from'         => $from ?: '+10000000000',
                    'to'           => $to,
                    'body'         => $body,
                    'status'       => 'simulated',
                    'is_read'      => true,
                    'contact_name' => $contactName,
                    'customer_id'  => $customerId,
                    'raw'          => ['simulated' => true],
                ]);
                return response()->json(['success' => true, 'simulated' => true, 'message' => $msg]);
            }
            return response()->json(['success' => false, 'message' => 'Telnyx SMS not configured.'], 422);
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.telnyx.com/v2/messages', [
                'from' => $from,
                'to'   => $to,
                'text' => $body,
            ]);

        $msg = TelnyxMessage::create([
            'telnyx_id'    => $response->json('data.id'),
            'direction'    => 'outbound',
            'type'         => 'sms',
            'from'         => $from,
            'to'           => $to,
            'body'         => $body,
            'status'       => $response->json('data.to.0.status') ?? ($response->successful() ? 'queued' : 'failed'),
            'is_read'      => true,
            'contact_name' => $contactName,
            'customer_id'  => $customerId,
            'raw'          => $response->json(),
        ]);

        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Telnyx error',
            'details' => $response->body(),
        ], $response->status());
    }

    // ── Star / Read / Delete ─────────────────────────────────────────────────

    /**
     * Toggle star on all messages in a thread (by phone) or a single message.
     */
    public function toggleStar(Request $request, int $id)
    {
        $msg = TelnyxMessage::findOrFail($id);
        $msg->update(['is_starred' => !$msg->is_starred]);
        return response()->json(['success' => true, 'is_starred' => $msg->is_starred]);
    }

    /**
     * Toggle star on all messages in a thread by phone number.
     */
    public function toggleThreadStar(Request $request, string $phone)
    {
        $decodedPhone = urldecode($phone);

        $messages = TelnyxMessage::sms()->where(function ($q) use ($decodedPhone) {
            $q->where('from', $decodedPhone)->orWhere('to', $decodedPhone);
        })->get();

        // If any message is starred, unstar all; otherwise star all
        $starred = !$messages->contains('is_starred', true);

        TelnyxMessage::sms()->where(function ($q) use ($decodedPhone) {
            $q->where('from', $decodedPhone)->orWhere('to', $decodedPhone);
        })->update(['is_starred' => $starred]);

        return response()->json(['success' => true, 'starred' => $starred]);
    }

    /**
     * Toggle read on a single message.
     */
    public function toggleRead(Request $request, int $id)
    {
        $msg = TelnyxMessage::findOrFail($id);
        $msg->update(['is_read' => !$msg->is_read]);
        return response()->json(['success' => true, 'is_read' => $msg->is_read]);
    }

    /**
     * Soft-delete a message, or force-delete if already trashed.
     */
    public function destroy(int $id)
    {
        $msg = TelnyxMessage::withTrashed()->findOrFail($id);

        if ($msg->trashed()) {
            $msg->forceDelete();
        } else {
            $msg->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Restore a soft-deleted message.
     */
    public function restore(int $id)
    {
        TelnyxMessage::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['success' => true]);
    }

    /**
     * Save a draft SMS (not sent yet).
     */
    public function saveDraft(Request $request)
    {
        $request->validate([
            'to'   => 'required|string',
            'body' => 'required|string',
        ]);

        $draft = TelnyxMessage::create([
            'direction'    => 'outbound',
            'type'         => 'sms',
            'from'         => config('services.telnyx.from_number', ''),
            'to'           => $request->to,
            'body'         => $request->body,
            'status'       => 'draft',
            'is_draft'     => true,
            'is_read'      => true,
            'customer_id'  => $request->customer_id ?: null,
            'contact_name' => $request->contact_name ?: null,
        ]);

        return response()->json(['success' => true, 'id' => $draft->id]);
    }

    /**
     * Sidebar counts as JSON (for live polling).
     */
    public function sidebarCounts()
    {
        return response()->json($this->getCounts());
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function getCounts(): array
    {
        return [
            'inbox'   => TelnyxMessage::sms()->notDraft()->inbound()->distinct('from')->count('from'),
            'unread'  => TelnyxMessage::sms()->notDraft()->inbound()->unread()->distinct('from')->count('from'),
            'starred' => TelnyxMessage::sms()->notDraft()->starred()->count(),
            'sent'    => TelnyxMessage::sms()->notDraft()->outbound()->distinct('to')->count('to'),
            'draft'   => TelnyxMessage::sms()->draft()->distinct('to')->count('to'),
            'deleted' => TelnyxMessage::sms()->onlyTrashed()->count(),
        ];
    }
}
