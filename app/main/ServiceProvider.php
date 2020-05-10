<?php

namespace Main;

use Admin\Classes\PermissionManager;
use Admin\Classes\Widgets;
use Event;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Illuminate\Support\Facades\View;
use Main\Classes\ThemeManager;
use Main\Template\Page;
use Setting;
use System\Libraries\Assets;
use System\Models\Settings_model;

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

        ThemeManager::instance()->bootThemes();

        $this->bootMenuItemEvents();

        if (!$this->app->runningInAdmin()) {
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
        else {
            $this->registerFormWidgets();
            $this->registerPermissions();
            $this->registerSystemSettings();
        }
    }

    protected function registerSingletons()
    {
    }

    protected function registerAssets()
    {
        Assets::registerCallback(function (Assets $manager) {
            $manager->registerSourcePath($this->app->themesPath());

            ThemeManager::addAssetsFromActiveThemeManifest($manager);
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

    /**
     * Registers events for menu items.
     */
    protected function bootMenuItemEvents()
    {
        Event::listen('pages.menuitem.listTypes', function () {
            return [
                'theme-page' => 'main::lang.pages.text_theme_page',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function ($type) {
            return Page::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function ($item, $url, $theme) {
            if ($item->type == 'theme-page')
                return Page::resolveMenuItem($item, $url, $theme);
        });
    }

    protected function registerFormWidgets()
    {
        Widgets::instance()->registerFormWidgets(function (Widgets $manager) {
            $manager->registerFormWidget('Main\FormWidgets\Components', [
                'label' => 'Components',
                'code' => 'components',
            ]);

            $manager->registerFormWidget('Main\FormWidgets\TemplateEditor', [
                'label' => 'Template editor',
                'code' => 'templateeditor',
            ]);
        });
    }

    protected function registerPermissions()
    {
        PermissionManager::instance()->registerCallback(function ($manager) {
            $manager->registerPermissions('System', [
                'Admin.MediaManager' => [
                    'label' => 'main::lang.permissions.media_manager', 'group' => 'main::lang.permissions.name',
                ],
                'Site.Themes' => [
                    'label' => 'main::lang.permissions.themes', 'group' => 'main::lang.permissions.name',
                ],
            ]);
        });
    }

    protected function registerSystemSettings()
    {
        Settings_model::registerCallback(function (Settings_model $manager) {
            $manager->registerSettingItems('core', [
                'media' => [
                    'label' => 'main::lang.settings.text_tab_media_manager',
                    'description' => 'main::lang.settings.text_tab_desc_media_manager',
                    'icon' => 'fa fa-image',
                    'priority' => 4,
                    'permission' => ['Site.Settings'],
                    'url' => admin_url('settings/edit/media'),
                    'form' => '~/app/main/models/config/media_settings',
                ],
            ]);
        });
    }
}