<?php

namespace Main;

use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Igniter\Flame\Pagic\Cache\FileSystem as FileCache;
use Igniter\Flame\Pagic\Parsers\FileParser;
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

        $this->resolveFlashSessionKey();
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

            FileParser::setCache(new FileCache(storage_path().'/system/cache'));
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
            $manager->loadAssetsFromFile($theme->publicPath.'/_meta/assets.json', 'theme');

    protected function resolveFlashSessionKey()
    {
        $this->app->resolving('flash', function (\Igniter\Flame\Flash\FlashBag $flash) {
            $flash->setSessionKey('flash_data_main');
        });
    }
}