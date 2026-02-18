<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TelnyxMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelnyxController extends Controller
{
    /**
     * Helper: whether simulate mode is enabled (reads TELNYX_ALLOW_SIMULATE from env)
     */
    protected function simulateEnabled(): bool
    {
        return filter_var(env('TELNYX_ALLOW_SIMULATE', false), FILTER_VALIDATE_BOOLEAN);
    }

    public function sendSms(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $apiKey = config('services.telnyx.api_key');
        $from = config('services.telnyx.from_number');

        // If required configuration missing, allow simulated response when enabled
        if (empty($apiKey) || empty($from)) {
            if ($this->simulateEnabled()) {
                Log::info('Telnyx SMS simulated because configuration is incomplete', [
                    'missing' => [
                        'api_key' => empty($apiKey),
                        'from' => empty($from),
                    ]
                ]);

                try {
                    $sim = TelnyxMessage::create([
                        'telnyx_id' => 'simulated-sms-'.time(),
                        'direction' => 'outbound',
                        'type' => 'sms',
                        'from' => $from ?: 'simulated',
                        'to' => $request->input('to'),
                        'body' => $request->input('message', 'Message from Dealer'),
                        'status' => 'simulated',
                        'raw' => ['simulated' => true, 'note' => 'Telnyx config incomplete']
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Telnyx simulated SMS save failed: '.$e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'simulated' => true,
                    'data' => [
                        'message' => 'Simulated SMS created (Telnyx not fully configured)',
                        'to' => $request->input('to'),
                        'from' => $from ?: null,
                    ]
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Telnyx not configured'], 500);
        }

        $payload = [
            'from' => $from,
            'to' => $request->input('to'),
            'text' => $request->input('message', 'Message from Dealer')
        ];

        // Optional Telnyx parameters supported by SDK/API
        if ($request->filled('messaging_profile_id')) {
            $payload['messaging_profile_id'] = $request->input('messaging_profile_id');
        }
        if ($request->filled('media_urls')) {
            $payload['media_urls'] = $request->input('media_urls');
        }
        if ($request->filled('webhook_url')) {
            $payload['webhook_url'] = $request->input('webhook_url');
        }
        if ($request->filled('webhook_failover_url')) {
            $payload['webhook_failover_url'] = $request->input('webhook_failover_url');
        }
        if ($request->filled('use_profile_webhooks')) {
            $payload['use_profile_webhooks'] = (bool)$request->input('use_profile_webhooks');
        }

        $response = Http::withToken($apiKey)
            ->post('https://api.telnyx.com/v2/messages', $payload);

        // persist outgoing message for audit
        try {
            TelnyxMessage::create([
                'telnyx_id' => $response->json('data.id') ?? null,
                'direction' => 'outbound',
                'type' => 'sms',
                'from' => $from,
                'to' => $request->input('to'),
                'body' => $request->input('message', ''),
                'status' => $response->json('data.state') ?? $response->status(),
                'raw' => $response->json()
            ]);
        } catch (\Exception $e) {
            Log::error('Telnyx save outgoing message failed: '.$e->getMessage());
        }

        if ($response->successful()) {
            return response()->json(['success' => true, 'data' => $response->json()]);
        }

        return response()->json(['success' => false, 'message' => 'Telnyx error', 'details' => $response->body()], $response->status());
    }

    public function makeCall(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
        ]);

        $apiKey = config('services.telnyx.api_key');
        $from = config('services.telnyx.from_number');
        $connectionId = config('services.telnyx.connection_id');

        if (empty($apiKey) || empty($from) || empty($connectionId)) {
            // If simulation mode enabled, return a simulated successful call
            if ($this->simulateEnabled()) {
                try {
                    $sim = TelnyxMessage::create([
                        'telnyx_id' => 'simulated-'.time(),
                        'direction' => 'outbound',
                        'type' => 'call',
                        'from' => $from ?: 'simulated',
                        'to' => $request->input('to'),
                        'body' => null,
                        'status' => 'simulated',
                        'raw' => ['simulated' => true, 'missing' => [
                            'apiKey' => empty($apiKey),
                            'from' => empty($from),
                            'connectionId' => empty($connectionId)
                        ]]
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Telnyx simulated call save failed: '.$e->getMessage());
                }

                return response()->json(['success' => true, 'simulated' => true, 'data' => ['message' => 'Simulated call created']]);
            }

            return response()->json(['success' => false, 'message' => 'Telnyx not fully configured'], 500);
        }

        $payload = [
            'connection_id' => $connectionId,
            'to' => $request->input('to'),
            'from' => $from,
        ];

        $response = Http::withToken($apiKey)
            ->post('https://api.telnyx.com/v2/calls', $payload);
        // persist outgoing call request
        try {
            TelnyxMessage::create([
                'telnyx_id' => $response->json('data.id') ?? null,
                'direction' => 'outbound',
                'type' => 'call',
                'from' => $from,
                'to' => $request->input('to'),
                'body' => null,
                'status' => $response->json('data.state') ?? $response->status(),
                'raw' => $response->json()
            ]);
        } catch (\Exception $e) {
            Log::error('Telnyx save outgoing call failed: '.$e->getMessage());
        }

        if ($response->successful() || $response->status() === 201) {
            return response()->json(['success' => true, 'data' => $response->json()]);
        }

        return response()->json(['success' => false, 'message' => 'Telnyx error', 'details' => $response->body()], $response->status());
    }

    /**
     * Retrieve a message from Telnyx by id
     */
    public function getMessage($id)
    {
        $apiKey = config('services.telnyx.api_key');
        if (empty($apiKey)) {
            if ($this->simulateEnabled()) {
                return response()->json(['success' => true, 'simulated' => true, 'data' => ['message' => 'Simulated getMessage (no API key)']]);
            }
            return response()->json(['success' => false, 'message' => 'Telnyx not configured'], 500);
        }

        $response = Http::withToken($apiKey)
            ->get("https://api.telnyx.com/v2/messages/{$id}");

        if ($response->successful()) return response()->json(['success' => true, 'data' => $response->json()]);
        return response()->json(['success' => false, 'message' => 'Telnyx error', 'details' => $response->body()], $response->status());
    }

    /**
     * List messages with optional filters
     */
    public function listMessages(Request $request)
    {
        $apiKey = config('services.telnyx.api_key');
        if (empty($apiKey)) {
            if ($this->simulateEnabled()) {
                return response()->json(['success' => true, 'simulated' => true, 'data' => []]);
            }
            return response()->json(['success' => false, 'message' => 'Telnyx not configured'], 500);
        }

        $params = [];
        if ($request->filled('page_size')) $params['page[size]'] = $request->input('page_size');
        if ($request->filled('page_number')) $params['page[number]'] = $request->input('page_number');
        if ($request->filled('from')) $params['filter[from]'] = $request->input('from');
        if ($request->filled('to')) $params['filter[to]'] = $request->input('to');

        $response = Http::withToken($apiKey)
            ->get('https://api.telnyx.com/v2/messages', $params);

        if ($response->successful()) return response()->json(['success' => true, 'data' => $response->json()]);
        return response()->json(['success' => false, 'message' => 'Telnyx error', 'details' => $response->body()], $response->status());
    }

    /**
     * Initiate a video call via Telnyx (WebRTC) and persist event.
     */
    public function makeVideoCall(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
        ]);

        $apiKey = config('services.telnyx.api_key');
        $from = config('services.telnyx.from_number');
        $connectionId = config('services.telnyx.connection_id');

        if (empty($apiKey) || empty($from) || empty($connectionId)) {
            if ($this->simulateEnabled()) {
                try {
                    TelnyxMessage::create([
                        'telnyx_id' => 'simulated-video-'.time(),
                        'direction' => 'outbound',
                        'type' => 'video_call',
                        'from' => $from ?: 'simulated',
                        'to' => $request->input('to'),
                        'body' => null,
                        'status' => 'simulated',
                        'raw' => ['simulated' => true]
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Telnyx simulated video call save failed: '.$e->getMessage());
                }
                return response()->json(['success' => true, 'simulated' => true, 'data' => ['message' => 'Simulated video call created']]);
            }

            return response()->json(['success' => false, 'message' => 'Telnyx not fully configured'], 500);
        }

        $payload = [
            'connection_id' => $connectionId,
            'to' => $request->input('to'),
            'from' => $from,
            'video' => true,
        ];

        $response = Http::withToken($apiKey)
            ->post('https://api.telnyx.com/v2/calls', $payload);

        // persist outgoing video call request
        try {
            TelnyxMessage::create([
                'telnyx_id' => $response->json('data.id') ?? null,
                'direction' => 'outbound',
                'type' => 'video_call',
                'from' => $from,
                'to' => $request->input('to'),
                'body' => null,
                'status' => $response->json('data.state') ?? $response->status(),
                'raw' => $response->json()
            ]);
        } catch (\Exception $e) {
            Log::error('Telnyx save outgoing video call failed: '.$e->getMessage());
        }

        if ($response->successful() || $response->status() === 201) {
            return response()->json(['success' => true, 'data' => $response->json()]);
        }

        return response()->json(['success' => false, 'message' => 'Telnyx error', 'details' => $response->body()], $response->status());
    }

    /**
     * Webhook endpoint for Telnyx events (inbound messages, delivery reports, call events)
     */
    public function webhook(Request $request)
    {
        $raw = $request->getContent();
        $payload = $request->all();

        // Verify signature if public key configured
        $publicKey = env('TELNYX_PUBLIC_KEY') ?: env('TELNYX_WEBHOOK_SECRET');
        $sig = $request->header('Telnyx-Signature-Ed25519') ?: $request->header('telnyx-signature-ed25519');
        $timestamp = $request->header('Telnyx-Timestamp') ?: $request->header('telnyx-timestamp');

        if ($publicKey && $sig && $timestamp) {
            try {
                $signed = $timestamp . '|' . $raw;
                $sigBin = hex2bin($sig);
                $pubBin = hex2bin($publicKey);
                if ($sigBin === false || $pubBin === false) {
                    Log::warning('Telnyx webhook: signature/publicKey not hex decodeable');
                } else {
                    if (!sodium_crypto_sign_verify_detached($sigBin, $signed, $pubBin)) {
                        Log::warning('Telnyx webhook signature mismatch');
                        return response()->json(['success' => false, 'message' => 'Invalid signature'], 401);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Telnyx webhook signature verification error: '.$e->getMessage());
                return response()->json(['success' => false, 'message' => 'Signature verification error'], 401);
            }
        }

        // Determine event type (Telnyx payloads sometimes use meta.event_type or data.event_type)
        $eventType = $payload['meta']['event_type'] ?? $payload['data']['event_type'] ?? $payload['type'] ?? null;

        // Normalize data container
        $data = $payload['data'] ?? [];

        try {
            // Persist or update existing record by telnyx id
            $telnyxId = $data['id'] ?? null;
            $record = null;
            if ($telnyxId) {
                $record = TelnyxMessage::where('telnyx_id', $telnyxId)->first();
            }

            $bodyText = $data['payload']['text'] ?? ($data['payload'] ?? null);
            $from = $data['from'] ?? ($data['payload']['from'] ?? null);
            $to = $data['to'] ?? ($data['payload']['to'] ?? null);
            $status = $data['state'] ?? null;

            $attrs = [
                'telnyx_id' => $telnyxId,
                'direction' => $data['direction'] ?? ($payload['direction'] ?? 'inbound'),
                'type' => $eventType ?? 'event',
                'from' => is_array($from) ? ($from['phone_number'] ?? null) : $from,
                'to' => is_array($to) ? ($to[0]['phone_number'] ?? null) : $to,
                'body' => is_array($bodyText) ? json_encode($bodyText) : $bodyText,
                'status' => $status,
                'raw' => $payload,
            ];

            if ($record) {
                $record->update($attrs);
            } else {
                TelnyxMessage::create($attrs);
            }
        } catch (\Exception $e) {
            Log::error('Telnyx webhook save failed: '.$e->getMessage());
        }

        // Optionally, you can trigger application events here (dispatch job, notify users, etc.)
        return response()->json(['received' => true]);
    }
}