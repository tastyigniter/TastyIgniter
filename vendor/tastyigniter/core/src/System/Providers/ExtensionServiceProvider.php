<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\System\Classes\ExtensionManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Override;

class ExtensionServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        // Register all extensions
        foreach (resolve(ExtensionManager::class)->getExtensions() as $extension) {
            $this->app->register($extension);
        }

        // Allow extensions to use the scheduler
        Event::listen('console.schedule', function($schedule) {
            $extensions = resolve(ExtensionManager::class)->getExtensions();
            foreach ($extensions as $extension) {
                if (method_exists($extension, 'registerSchedule')) {
                    $extension->registerSchedule($schedule);
                }
            }
        });
    }
}
