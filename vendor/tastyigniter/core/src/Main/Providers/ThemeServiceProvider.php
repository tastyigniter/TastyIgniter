<?php

declare(strict_types=1);

namespace Igniter\Main\Providers;

use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Pagic\Router;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\SupportConfigurableComponent;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Template\Page;
use Igniter\System\Classes\ComponentManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use Override;

class ThemeServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->register(LivewireServiceProvider::class);

        $this->callAfterResolving(Router::class, function($router) {
            $router::$templateClass = Page::class;
            $router->setTheme(Theme::getActiveCode());
        });

        Livewire::componentHook(SupportConfigurableComponent::class);
    }

    public function boot(): void
    {
        $this->app->booted(function() {
            Model::extend(function(Model $model) {
                $model->setSource(Theme::getActiveCode());
            });

            resolve(ComponentManager::class)->bootComponents();

            resolve(ThemeManager::class)->bootThemes();

            if (!Igniter::hasDatabase(true)) {
                return;
            }

            Event::listen('main.controller.beforeRemap', function(MainController $controller) {
                $controller->getTheme()?->loadThemeFile();
            });
        });
    }
}
