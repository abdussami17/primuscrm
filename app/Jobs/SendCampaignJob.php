<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\CampaignMail;

class SendCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
        $this->onQueue('campaigns');
    }

    public function handle()
    {
        $campaign = $this->campaign->fresh();
        if (!$campaign) return;

        $recipients = $campaign->recipients ?? [];
        if (!is_array($recipients)) {
            try { $recipients = json_decode($recipients, true) ?: []; } catch (\Throwable $e) { $recipients = []; }
        }

        foreach ($recipients as $r) {
            $email = null;
            $name = null;

            if (is_array($r)) {
                $email = $r['email'] ?? $r['contact'] ?? null;
                $name = $r['name'] ?? null;
            } elseif (is_numeric($r)) {
                $cust = Customer::find($r);
                if ($cust) {
                    $email = $cust->email;
                    $name = $cust->name ?? null;
                }
            } elseif (is_string($r) && strpos($r, '@') !== false) {
                $email = $r;
            }

            if (!$email) continue;

            try {
                Mail::to($email)->send(new CampaignMail($campaign, $name));
            } catch (\Throwable $e) {
                // Log and continue
                logger()->error('Campaign mail send failed', ['campaign_id' => $campaign->id, 'email' => $email, 'error' => $e->getMessage()]);
            }
        }

        // mark campaign as sent or update status
        $campaign->update(['status' => 'sent']);
    }
}
