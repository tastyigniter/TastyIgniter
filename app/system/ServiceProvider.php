<?php

namespace System;

use Admin\Classes\Navigation;
use Admin\Classes\Template;
use Admin\Classes\User;
use Admin\Helpers\Admin as AdminHelper;
use App;
use Config;
use Event;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Igniter\Flame\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Request;
use System\Classes\ErrorHandler;
use System\Classes\ExtensionManager;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        parent::register('system');

        $this->registerSingletons();

        // Register all extensions
        ExtensionManager::instance()->registerExtensions();

        $this->registerConsole();
//        $this->registerErrorHandler();
        $this->registerActivityLogger();
//        $this->registerTwigParser();
//        $this->registerMailer();
//        $this->registerMarkupTags();
        $this->registerPaginator();

        // Register admin and main module providers
        collect(Config::get('system.modules', []))->each(function ($module) {
            if (strtolower(trim($module)) != 'system') {
                $this->app->register('\\'.$module.'\ServiceProvider');
            }
        });

        // Admin specific
        if ($this->app->runningInAdmin()) {
//            $this->registerAdminNavigation();
//            $this->registerAdminReportWidgets();
            $this->registerAdminSettings();
        }
    }

    /**
     * Bootstrap the module events.
     * @return void
     */
    public function boot()
    {
        // Boot extensions
        parent::boot('system');

        $this->includeHelpers();

        ExtensionManager::instance()->initializeExtensions();

        $this->extendValidator();
    }

    /**
     * Register singletons
     */
    protected function registerSingletons()
    {
//        App::singleton('main.helper', function () {
//            return new \Main\Helpers\Main;
//        });

        App::singleton('admin.helper', function () {
            return new AdminHelper;
        });

        App::singleton('admin.auth', function () {
            return User::instance();
        });

        App::singleton('assets', function ($app) {
            return new Libraries\Assets($app);
        });

        App::singleton('admin.menu', function ($app) {
            return Navigation::instance();
        });

        App::singleton('admin.template', function ($app) {
            return new Template($app['config']['template']);
        });
    }

    /**
     * Register command line specifics
     */
    protected function registerConsole()
    {
        // Allow extensions to use the scheduler
        Event::listen('console.schedule', function ($schedule) {
            $extensions = ExtensionManager::instance()->getExtensions();
            foreach ($extensions as $extension) {
                if (method_exists($extension, 'registerSchedule')) {
                    $extension->registerSchedule($schedule);
                }
            }
        });

        foreach (
            [
                'igniter.up'      => Console\Commands\IgniterUp::class,
                'igniter.down'    => Console\Commands\IgniterDown::class,
                'igniter.install' => Console\Commands\IgniterInstall::class,
                'igniter.update'  => Console\Commands\IgniterUpdate::class,
            ] as $command => $class
        ) {
            $this->registerConsoleCommand($command, $class);
        }
    }

    /*
     * Error handling for uncaught Exceptions
     */
    protected function registerErrorHandler()
    {
        Event::listen('exception.beforeRender', function ($exception, $httpCode, $request) {
            return (new ErrorHandler)->handleException($exception);
        });
    }

    /*
     * Activity Logger for logging model events
     */
    protected function registerActivityLogger()
    {
//        $this->app->register(Ac);
    }

    /*
     * Include helpers
     */
    protected function includeHelpers()
    {
        foreach (glob(__DIR__.'/helpers/*_helper.php') as $file) {
            include_once $file;
        }
    }

    /**
     * Extends the validator with custom rules
     */
    protected function extendValidator()
    {
//        Validator::extend('extensions', function ($attribute, $value, $parameters) {
//            $extension = strtolower($value->getClientOriginalExtension());
//
//            return in_array($extension, $parameters);
//        });
//
//        Validator::replacer('extensions', function ($message, $attribute, $rule, $parameters) {
//            return strtr($message, [':values' => implode(', ', $parameters)]);
//        });

        Validator::extend('valid_date', function ($attribute, $value, $parameters, $validator) {
            return ( ! preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $value)
                AND ! preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $value)) ? FALSE : TRUE;
        });

        Validator::extend('valid_time', function ($attribute, $value, $parameters, $validator) {
            return ( ! preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $value)
                AND ! preg_match('/^(1[012]|[1-9]):[0-5][0-9](\s)?(?i)(am|pm)$/', $value)) ? FALSE : TRUE;
        });

        Validator::extend('valid_lat_lng', function ($attribute, $value, $parameters, $validator) {
            // @todo: implement
        });
    }

    protected function registerPaginator()
    {
        Paginator::defaultView('system::_partials/pagination/default');
        Paginator::defaultSimpleView('system::_partials/pagination/simple_default');

        Paginator::currentPathResolver(function () {
            return current_url();
        });

        Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = Request::get($pageName);
            if (filter_var($page, FILTER_VALIDATE_INT) !== FALSE && (int)$page >= 1) {
                return $page;
            }

            return 1;
        });
    }

    protected function registerAdminSettings()
    {
//        Setting::setExtraColumns(['sort' => 'prefs']);
    }
}