<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Email inbound polling — runs every 2 minutes via the Laravel scheduler.
| Make sure the scheduler cron is configured on your server:
|   * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
|--------------------------------------------------------------------------
*/
Schedule::command('email:fetch-inbound')->everyTwoMinutes()->withoutOverlapping();

/*
|--------------------------------------------------------------------------
| Smart Sequences — evaluate criteria, schedule & execute actions.
| Runs every 5 minutes to pick up new matches and execute due actions.
|--------------------------------------------------------------------------
*/
Schedule::command('sequences:process')->everyFiveMinutes()->withoutOverlapping();
