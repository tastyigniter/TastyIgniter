<?php

declare(strict_types=1);

namespace Igniter\User\Subscribers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;

class ConsoleSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            'console.schedule' => 'defineSchedule',
        ];
    }

    public function defineSchedule(Schedule $schedule): void
    {
        $this->checkForAssignablesToAssignEveryMinute($schedule);
        $this->clearUserExpiredCustomAwayStatus($schedule);
    }

    protected function checkForAssignablesToAssignEveryMinute(Schedule $schedule): void
    {
        $schedule->command('igniter:assignable-allocate')
            ->name('Assignables Allocator')
            ->withoutOverlapping(5)
            ->runInBackground()
            ->everyMinute();
    }

    protected function clearUserExpiredCustomAwayStatus(Schedule $schedule): void
    {
        $schedule->command('igniter:user-state-clear')
            ->name('Clear user custom away status')
            ->withoutOverlapping(5)
            ->runInBackground()
            ->everyMinute();
    }
}
