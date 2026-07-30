<?php

declare(strict_types=1);

namespace Igniter\System\Jobs;

use Igniter\System\Health\Checks\BackgroundTasksCheck;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class QueueHeartbeatJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        Cache::put(
            BackgroundTasksCheck::QUEUE_HEARTBEAT_KEY,
            now()->toDateTimeString(),
            now()->addMinutes(10),
        );
    }
}
