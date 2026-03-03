<?php

namespace App\Console\Commands;

use App\Jobs\ProcessSmartSequenceActionJob;
use App\Models\Customer;
use App\Models\SequenceExecutionLog;
use App\Models\SmartSequence;
use App\Services\SmartSequenceCriteriaEvaluator;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessSmartSequences extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sequences:process 
                            {--dry-run : Show what would be processed without actually doing it}
                            {--sequence= : Process only a specific sequence ID}';

    /**
     * The console command description.
     */
    protected $description = 'Process active smart sequences: evaluate criteria, schedule actions, and execute due actions.';

    public function __construct(
        protected SmartSequenceCriteriaEvaluator $evaluator
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $isDryRun = $this->option('dry-run');
        $specificId = $this->option('sequence');

        $this->info('Smart Sequence Processor started at ' . $now->format('Y-m-d H:i:s'));

        // ───────────────────────────────────────────────────
        // PHASE 1: Evaluate criteria & schedule new actions
        // ───────────────────────────────────────────────────
        $this->info('');
        $this->info('Phase 1: Evaluating active sequences and scheduling actions...');

        $query = SmartSequence::active()
            ->with(['criteriaGroups.criteria', 'actions'])
            ->has('actions')
            ->has('criteriaGroups');

        if ($specificId) {
            $query->where('id', $specificId);
        }

        $sequences = $query->get();

        $totalScheduled = 0;

        foreach ($sequences as $sequence) {
            $this->line("  Processing: [{$sequence->id}] {$sequence->title}");

            try {
                $matchingCustomers = $this->evaluator->getMatchingCustomers($sequence);

                if ($matchingCustomers->isEmpty()) {
                    $this->line("    → No matching customers found");
                    continue;
                }

                $this->line("    → Found {$matchingCustomers->count()} matching customer(s)");

                $actions = $sequence->actions()->orderBy('sort_order')->get();

                foreach ($matchingCustomers as $customer) {
                    $scheduled = $this->scheduleActionsForCustomer($sequence, $actions, $customer, $now, $isDryRun);
                    $totalScheduled += $scheduled;
                }

            } catch (\Throwable $e) {
                $this->error("    → Error: {$e->getMessage()}");
                Log::error('SmartSequence: evaluation failed', [
                    'sequence_id' => $sequence->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        $this->info("  → Total new actions scheduled: {$totalScheduled}");

        // ───────────────────────────────────────────────────
        // PHASE 2: Execute due pending actions
        // ───────────────────────────────────────────────────
        $this->info('');
        $this->info('Phase 2: Executing due actions...');

        $dueActions = SequenceExecutionLog::ready()
            ->with(['sequence', 'action'])
            ->orderBy('scheduled_at')
            ->limit(500)
            ->get();

        $executed = 0;
        $failed = 0;

        foreach ($dueActions as $log) {
            // Double-check the sequence is still active
            if (!$log->sequence || !$log->sequence->is_active) {
                $log->markAsCancelled();
                continue;
            }

            if ($isDryRun) {
                $actionType = $log->action->action_type ?? 'unknown';
                $this->line("  [DRY RUN] Would execute: log #{$log->id} - {$actionType} for customer #{$log->lead_id}");
                continue;
            }

            try {
                // Dispatch synchronously for immediate execution (same pattern as campaigns)
                ProcessSmartSequenceActionJob::dispatchSync($log->id);
                $executed++;

                // Refresh to check outcome
                $log->refresh();
                if ($log->status === SequenceExecutionLog::STATUS_COMPLETED) {
                    $actionType = $log->action->action_type ?? 'unknown';
                    $this->line("  ✓ Executed: log #{$log->id} - {$actionType} for customer #{$log->lead_id}");
                } else {
                    $this->warn("  ✗ Failed: log #{$log->id} - {$log->error_message}");
                    $failed++;
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->error("  ✗ Error on log #{$log->id}: {$e->getMessage()}");
                Log::error('SmartSequence: action dispatch failed', [
                    'log_id' => $log->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("  → Executed: {$executed}, Failed: {$failed}");

        // ───────────────────────────────────────────────────
        // SUMMARY
        // ───────────────────────────────────────────────────
        $this->info('');
        $this->info('Smart Sequence Processor completed.');
        $this->info("  Sequences processed: {$sequences->count()}");
        $this->info("  New actions scheduled: {$totalScheduled}");
        $this->info("  Actions executed: {$executed}");
        $this->info("  Actions failed: {$failed}");

        return self::SUCCESS;
    }

    /**
     * Schedule actions for a matching customer.
     * Only schedules if the customer doesn't already have pending/processing actions for this sequence.
     */
    protected function scheduleActionsForCustomer(
        SmartSequence $sequence,
        $actions,
        Customer $customer,
        Carbon $now,
        bool $isDryRun
    ): int {
        $scheduled = 0;

        foreach ($actions as $action) {
            // Check if this action is already scheduled/pending/processing for this customer
            $existingLog = SequenceExecutionLog::where('smart_sequence_id', $sequence->id)
                ->where('sequence_action_id', $action->id)
                ->where('lead_id', $customer->id)
                ->whereIn('status', [
                    SequenceExecutionLog::STATUS_PENDING,
                    SequenceExecutionLog::STATUS_PROCESSING,
                ])
                ->exists();

            if ($existingLog) {
                continue; // Already scheduled, skip
            }

            // Check if this action was already completed for this customer
            $completedLog = SequenceExecutionLog::where('smart_sequence_id', $sequence->id)
                ->where('sequence_action_id', $action->id)
                ->where('lead_id', $customer->id)
                ->where('status', SequenceExecutionLog::STATUS_COMPLETED)
                ->exists();

            if ($completedLog) {
                continue; // Already executed successfully, skip
            }

            // Calculate scheduled time based on delay
            $scheduledAt = $this->calculateScheduledTime($action, $now);

            // Check if there's a specific time_of_day configured
            $timeOfDay = $action->getParameter('time_of_day');
            if ($timeOfDay) {
                $scheduledAt = $this->applyTimeOfDay($scheduledAt, $timeOfDay);
            }

            if ($isDryRun) {
                $this->line("    [DRY RUN] Would schedule: {$action->action_type} for customer #{$customer->id} at {$scheduledAt->format('Y-m-d H:i:s')}");
                $scheduled++;
                continue;
            }

            // Create the execution log
            SequenceExecutionLog::create([
                'smart_sequence_id' => $sequence->id,
                'sequence_action_id' => $action->id,
                'lead_id' => $customer->id,
                'status' => SequenceExecutionLog::STATUS_PENDING,
                'scheduled_at' => $scheduledAt,
            ]);

            $scheduled++;
        }

        return $scheduled;
    }

    /**
     * Calculate the scheduled execution time based on the action's delay settings.
     * The delay is cumulative from the current time.
     */
    protected function calculateScheduledTime($action, Carbon $now): Carbon
    {
        $delaySeconds = $action->getDelayInSeconds();

        if ($delaySeconds <= 0) {
            return $now->copy();
        }

        return $now->copy()->addSeconds($delaySeconds);
    }

    /**
     * Apply a specific time-of-day to the scheduled date.
     */
    protected function applyTimeOfDay(Carbon $scheduledAt, string $timeOfDay): Carbon
    {
        try {
            $parts = explode(':', $timeOfDay);
            $hour = (int) ($parts[0] ?? 0);
            $minute = (int) ($parts[1] ?? 0);

            $scheduledAt->setTime($hour, $minute, 0);

            // If the resulting time is in the past, push to next day
            if ($scheduledAt->isPast()) {
                $scheduledAt->addDay();
            }
        } catch (\Throwable $e) {
            Log::warning("SmartSequence: invalid time_of_day '{$timeOfDay}'");
        }

        return $scheduledAt;
    }
}
