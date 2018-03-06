<?php

namespace Main;

use App;
use Config;
use File;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Igniter\Flame\Pagic\Cache\FileSystem as FileCache;
use Igniter\Flame\Pagic\Parsers\FileParser;
use Main\Classes\ThemeManager;
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
            $this->registerBaseTags();

            FileParser::setCache(new FileCache(Config::get('system.templateCachePath', FALSE)));
        }
    }

    protected function registerSingletons()
    {
        App::singleton('captcha', function ($app) {
            return new Libraries\Captcha($app);
        });
    }

    protected function registerBaseTags()
    {
        Assets::defaultPaths([
            $this->app->themesPath(),
            app_path($this->app->appContext().'/views'),
        ]);

        Assets::registerAssets(function (Assets $manager) {
            $manager->collection('app')->addTags([
                'meta' => [
                    ['name' => 'description', 'content' => setting('meta_description')],
                    ['name' => 'keywords', 'content' => setting('meta_keywords')],
                ],
                'css'  => [
                    [assets_url('css/vendor/bootstrap.min.css'), 'bootstrap-css'],
                    [assets_url('css/vendor/font-awesome.min.css'), 'font-awesome-css'],
                    [assets_url('css/app/app.css'), 'app-css'],
                ],
                'js'   => [
                    [assets_url('js/app/vendor.js'), 'vendor-js'],
                    [assets_url('js/app/flashmessage.js'), 'flashmessage-js'],
                    [assets_url('js/app/app.js'), 'app-js'],
                ],
            ]);

            $theme = ThemeManager::instance()->getActiveTheme();
            $assetsConfigPath = $theme->getPath().'/_meta/assets.json';
            if (File::exists($assetsConfigPath)) {
                $manager->collection('theme')->addTags(
                    json_decode(File::get($assetsConfigPath), TRUE)
                );
            }
        });
    }
}