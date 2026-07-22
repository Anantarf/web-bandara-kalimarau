<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('model:prune')->daily();

// Daily DB + storage/app/public backup (see config/backup.php), plus a
// weekly cleanup of old backups per the retention policy in that config.
// Requires the production server's cron to actually call `schedule:run`
// (see docs/GO-LIVE.md) — this alone does nothing without that cron entry.
Schedule::command('backup:run')->daily()->at('01:00');
Schedule::command('backup:clean')->daily()->at('01:30');
