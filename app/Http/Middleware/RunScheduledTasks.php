<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pseudo-cron middleware.
 *
 * On every authenticated page request, checks whether scheduled tasks
 * are due and runs them *after* the response has been sent to the browser
 * (via the terminate() method), so the user experiences zero delay.
 *
 * This eliminates the need for a server-side cron job.
 */
class RunScheduledTasks
{
    /**
     * Task definitions: command => interval in seconds.
     */
    protected array $tasks = [
        'sequences:process'   => 300,  // every 5 minutes
        'email:fetch-inbound' => 60,  // every 1 minute
        'campaigns:process'   => 180,  // every 3 minutes
    ];

    /**
     * Pass the request through — nothing happens here.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Run after the response has been sent to the browser.
     * This is the ideal place for background-ish work without
     * a real queue or cron.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Only run on normal GET web requests from authenticated users
        if (!$request->isMethod('GET') || !auth()->check()) {
            return;
        }

        // Skip AJAX / JSON requests
        if ($request->ajax() || $request->wantsJson()) {
            return;
        }

        foreach ($this->tasks as $command => $intervalSeconds) {
            $this->runIfDue($command, $intervalSeconds);
        }
    }

    /**
     * Run a command if enough time has elapsed since its last execution.
     * Uses an atomic cache lock to prevent overlapping runs.
     */
    protected function runIfDue(string $command, int $intervalSeconds): void
    {
        $cacheKey = 'scheduled_task:' . str_replace(':', '_', $command);
        $lockKey  = $cacheKey . ':lock';

        // Check if interval has elapsed
        $lastRun = Cache::get($cacheKey);
        if ($lastRun && (time() - $lastRun) < $intervalSeconds) {
            return; // Not due yet
        }

        // Acquire a lock so only one request runs this task at a time
        $lock = Cache::lock($lockKey, $intervalSeconds);

        if (!$lock->get()) {
            return; // Another request is already running this task
        }

        try {
            // Mark as running NOW to prevent other requests from trying
            Cache::put($cacheKey, time(), $intervalSeconds * 2);

            Artisan::call($command);

            Log::info("Pseudo-cron: executed '{$command}'");
        } catch (\Throwable $e) {
            Log::error("Pseudo-cron: '{$command}' failed — {$e->getMessage()}");
        } finally {
            $lock->release();
        }
    }
}
