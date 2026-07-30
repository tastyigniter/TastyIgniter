<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Facades\Igniter\System\Helpers\CacheHelper;
use Igniter\Flame\Providers\EventServiceProvider as FlameEventServiceProvider;
use Igniter\System\Models\Language;
use Igniter\System\Models\Observers\LanguageObserver;
use Illuminate\Support\Facades\Event;
use Override;

class EventServiceProvider extends FlameEventServiceProvider
{
    protected $observers = [
        Language::class => LanguageObserver::class,
    ];

    #[Override]
    public function boot(): void
    {
        // Allow system based cache clearing
        $this->handleCacheCleared();
    }

    protected function handleCacheCleared()
    {
        Event::listen('cache:cleared', function() {
            CacheHelper::clearInternal();
        });
    }
}
