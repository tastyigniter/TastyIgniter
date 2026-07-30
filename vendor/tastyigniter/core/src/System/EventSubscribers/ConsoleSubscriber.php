<?php

declare(strict_types=1);

namespace Igniter\System\EventSubscribers;

use Facades\Igniter\System\Helpers\CacheHelper;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Artisan;

class ConsoleSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            'console.schedule' => 'defineSchedule',
            CommandStarting::class => 'handleCommandStarting',
            CommandFinished::class => 'handleCommandFinished',
        ];
    }

    public function defineSchedule(Schedule $schedule): void
    {
        // Periodically check for system updates
        $schedule->command('igniter:update', ['--check'])
            ->name('System Updates Checker')
            ->everyThreeHours()
            ->evenInMaintenanceMode();

        // Daily check for model records to prune every day
        $schedule->command('model:prune', [
            '--model' => Igniter::prunableModels(),
        ])->name('Prunable Models Checker')->daily();
    }

    public function handleCommandStarting(CommandStarting $event) {}

    public function handleCommandFinished(CommandFinished $event): void
    {
        match ($event->command) {
            'package:discover' => Artisan::call('igniter:package-discover', [], $event->output),
            'clear-compiled' => CacheHelper::clearCompiled(),
            default => null,
        };
    }
}
