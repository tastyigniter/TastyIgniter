<?php

namespace Main;

use Event;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Main\Classes\ThemeManager;
use Setting;
use System\Libraries\Assets;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot('main');

        View::share('site_name', Setting::get('site_name'));
        View::share('site_logo', Setting::get('site_logo'));

        if (!$this->app->runningInAdmin()) {
            $this->registerBladeDirectives();
            $this->resolveFlashSessionKey();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register('main');

        if (!$this->app->runningInAdmin()) {
            $this->registerSingletons();
            $this->registerAssets();
            $this->registerCombinerEvent();
        }
    }

    protected function registerSingletons()
    {
    }

    protected function registerAssets()
    {
        Assets::registerCallback(function (Assets $manager) {
            $manager->registerSourcePath($this->app->themesPath());

            $theme = ThemeManager::instance()->getActiveTheme();
            $manager->addFromManifest($theme->publicPath.'/_meta/assets.json');
        });
    }

    protected function registerCombinerEvent()
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        Event::listen('assets.combiner.beforePrepare', function (Assets $combiner, $assets) {
            ThemeManager::applyAssetVariablesOnCombinerFilters(
                array_flatten($combiner->getFilters())
            );
        });
    }

    protected function resolveFlashSessionKey()
    {
        $this->app->resolving('flash', function (\Igniter\Flame\Flash\FlashBag $flash) {
            $flash->setSessionKey('flash_data_main');
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('component', function ($expression) {
            return "<?php echo component({$expression}); ?>";
        });

        Blade::directive('endcomponent', function ($expression) {
            return '';
        });

        Blade::directive('has_component', function ($expression) {
            return "<?php echo has_component({$expression}); ?>";
        });

        Blade::directive('partial', function ($expression) {
            return "<?php echo partial({$expression}); ?>";
        });

        Blade::directive('content', function ($expression) {
            return "<?php echo controller()->renderContent({$expression}); ?>";
        });
    }
}