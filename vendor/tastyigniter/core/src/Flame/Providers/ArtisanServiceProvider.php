<?php

declare(strict_types=1);

namespace Igniter\Flame\Providers;

use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Event;

class ArtisanServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            Event::listen(ArtisanStarting::class, function(): void {
                Event::dispatch('console.schedule', [$this->app->make(Schedule::class)]);
            });
        }
    }
}
