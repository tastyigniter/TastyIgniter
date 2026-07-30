<?php

declare(strict_types=1);

namespace Igniter\Main;

use Igniter\Flame\Providers\AppServiceProvider;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\MediaLibrary;
use Igniter\Main\Classes\RouteRegistrar;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Components\BlankComponent;
use Igniter\Main\Components\ViewBag;
use Igniter\Main\Http\Middleware\CheckInitialSetup;
use Igniter\Main\Http\Middleware\CheckMaintenance;
use Igniter\Main\Providers\AssetsServiceProvider;
use Igniter\Main\Providers\FormServiceProvider;
use Igniter\Main\Providers\MenuItemServiceProvider;
use Igniter\Main\Providers\PagicServiceProvider;
use Igniter\Main\Providers\PermissionServiceProvider;
use Igniter\Main\Providers\ThemeServiceProvider;
use Igniter\Main\Template\Extension\BladeExtension;
use Igniter\System\Classes\ComponentManager;
use Igniter\System\Models\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Override;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Bootstrap the service provider.
     */
    public function boot(): void
    {
        $this->loadViewsFrom($this->root.'/resources/views/main', 'igniter.main');

        $this->app->booted(function() {
            View::share('site_name', Settings::get('site_name'));
            View::share('site_logo', Settings::get('site_logo'));

            $this->defineRoutes();
        });
    }

    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->registerSingletons();
        $this->registerComponents();
        $this->registerBladeDirectives();

        Igniter::loadControllersFrom(igniter_path('src/Main/Http/Controllers'), 'Igniter\\Main\\Http\\Controllers');

        Route::pushMiddlewareToGroup('igniter', CheckMaintenance::class);
        Route::pushMiddlewareToGroup('igniter', CheckInitialSetup::class);

        $this->app->register(AssetsServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(MenuItemServiceProvider::class);
        $this->app->register(PagicServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
    }

    /**
     * Register components.
     */
    protected function registerComponents()
    {
        resolve(ComponentManager::class)->registerCallback(function(ComponentManager $manager) {
            $manager->registerComponent(BlankComponent::class, [
                'code' => 'blankComponent',
                'name' => 'Blank Component',
            ]);

            $manager->registerComponent(ViewBag::class, [
                'code' => 'viewBag',
                'name' => 'ViewBag Component',
                'description' => 'Stores custom template properties.',
            ]);
        });
    }

    protected function registerSingletons()
    {
        $this->tapSingleton(MediaLibrary::class);
        $this->tapSingleton(ThemeManager::class);
    }

    protected function defineRoutes()
    {
        if (!app()->routesAreCached()) {
            Route::group([], function($router) {
                (new RouteRegistrar($router))->all();
            });
        }
    }

    protected function registerBladeDirectives()
    {
        $this->callAfterResolving('blade.compiler', function($compiler, $app) {
            (new BladeExtension)->register();
        });
    }
}
