<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\System\Health\Checks\ApplicationCheck;
use Igniter\System\Health\Checks\BackgroundTasksCheck;
use Igniter\System\Health\Checks\CacheUsageCheck;
use Igniter\System\Health\Checks\DirectoryPermissionsCheck;
use Igniter\System\Health\Checks\ExtensionThemeVersionCheck;
use Igniter\System\Health\Checks\PhpCheck;
use Igniter\System\Health\Checks\WebServerSecurityCheck;
use Igniter\System\Health\HealthManager;
use Igniter\System\Jobs\QueueHeartbeatJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Override;

class HealthServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(HealthManager::class);

        HealthManager::registerCallback(function(HealthManager $manager) {
            $manager->registerChecks([
                ApplicationCheck::new(),
                PhpCheck::new(),
                DirectoryPermissionsCheck::new(),
                WebServerSecurityCheck::new(),
                BackgroundTasksCheck::new(),
                ExtensionThemeVersionCheck::new(),
                CacheUsageCheck::new(),
            ]);
        });
    }

    public function boot(): void
    {
        $this->app['events']->listen('console.schedule', function(Schedule $schedule) {
            $schedule->call(function() {
                Cache::put(BackgroundTasksCheck::SCHEDULE_HEARTBEAT_KEY, now()->toDateTimeString(), now()->addMinutes(5));
            })->everyMinute()->name('system-schedule-heartbeat');

            $schedule->call(function() {
                if (config('queue.default') !== 'sync') {
                    QueueHeartbeatJob::dispatch();
                }
            })->everyMinute()->name('system-queue-heartbeat');
        });
    }
}
