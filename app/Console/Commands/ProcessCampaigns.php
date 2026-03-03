<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Jobs\SendCampaignJob;
use Illuminate\Support\Carbon;

class ProcessCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process due campaigns and dispatch send jobs based on their timing and type.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $dispatched = 0;

        // ── ONE-TIME campaigns ────────────────────────────────────────────────
        // Pick up: status='scheduled' OR status='sending' with no last_sent_at (stuck)
        // start_at <= now (or null = send immediately)
        $onceCampaigns = Campaign::where('set_type', 'once')
            ->where(function ($q) {
                $q->where('status', 'scheduled')
                  ->orWhere(function ($q2) {
                      // Stuck in 'sending' but never actually sent — no last_sent_at
                      $q2->where('status', 'sending')->whereNull('last_sent_at');
                  });
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', $now);
            })
            ->get();

        foreach ($onceCampaigns as $campaign) {
            try {
                $campaign->update(['status' => 'sending', 'last_sent_at' => $now]);
                // Run synchronously — no queue worker required
                SendCampaignJob::dispatchSync($campaign);
                $dispatched++;
                $this->info("Sent one-time campaign #{$campaign->id}: {$campaign->name}");
            } catch (\Throwable $e) {
                $this->error("Failed campaign #{$campaign->id}: " . $e->getMessage());
                logger()->error('ProcessCampaigns: dispatch failed', [
                    'campaign_id' => $campaign->id,
                    'error'       => $e->getMessage(),
                ]);
            }
        }

        // ── DRIP campaigns ────────────────────────────────────────────────────
        // Initial send: status = 'scheduled' or stuck 'sending' with no last_sent_at, start_at <= now
        // Subsequent sends: status = 'sending', last_sent_at + drip_days <= now
        $dripCampaigns = Campaign::where('set_type', 'drip')
            ->whereIn('status', ['scheduled', 'sending'])
            ->where(function ($q) use ($now) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', $now);
            })
            ->get();

        foreach ($dripCampaigns as $campaign) {
            // Check whether it's time for the next drip send
            if ($campaign->status === 'sending' && $campaign->last_sent_at) {
                $nextSend = Carbon::parse($campaign->last_sent_at)->addDays((int)($campaign->drip_days ?: 1));
                if ($now->lt($nextSend)) {
                    continue; // Not yet due for next drip
                }
            }

            try {
                $campaign->update([
                    'status'       => 'sending',
                    'last_sent_at' => $now,
                ]);
                // Run synchronously — no queue worker required
                SendCampaignJob::dispatchSync($campaign);
                $dispatched++;
                $this->info("Sent drip campaign #{$campaign->id}: {$campaign->name}");
            } catch (\Throwable $e) {
                $this->error("Failed drip campaign #{$campaign->id}: " . $e->getMessage());
                logger()->error('ProcessCampaigns: drip dispatch failed', [
                    'campaign_id' => $campaign->id,
                    'error'       => $e->getMessage(),
                ]);
            }
        }

        $this->info("campaigns:process complete — {$dispatched} campaign(s) dispatched.");

        return self::SUCCESS;
    }
}
