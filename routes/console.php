<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('model:prune')->daily();

if (config('queue.default') === 'database') {
    Schedule::command('queue:work --queue=media --stop-when-empty --max-time=50 --tries=3')
        ->everyMinute()
        ->withoutOverlapping();
}

// Daily DB + storage/app/public backup (see config/backup.php), plus a
// weekly cleanup of old backups per the retention policy in that config.
// Requires the production server's cron to actually call `schedule:run`
// (see docs/GO-LIVE.md) ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â this alone does nothing without that cron entry.
Schedule::command('backup:run')->daily()->at('01:00');
Schedule::command('backup:clean')->daily()->at('01:30');
Schedule::command('media:audit')->weeklyOn(1, '02:00')->appendOutputTo(storage_path('logs/media-audit.log'));
Schedule::command('sanctum:prune-expired')->daily();
