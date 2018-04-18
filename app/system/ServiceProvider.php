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
use Igniter\Flame\Translation\Drivers\Database;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Main\Classes\Customer;
use Request;
use Setting;
use System\Classes\ErrorHandler;
use System\Classes\ExtensionManager;
use System\Models\Mail_templates_model;
use System\Models\Settings_model;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->includeHelpers();

        parent::register('system');

        $this->registerSingletons();

        // Register all extensions
        ExtensionManager::instance()->registerExtensions();

        $this->registerConsole();
        $this->registerErrorHandler();
        $this->registerMailer();
        $this->registerPaginator();
        $this->registerCurrency();

        // Register admin and main module providers
        collect(Config::get('system.modules', []))->each(function ($module) {
            if (strtolower(trim($module)) != 'system') {
                $this->app->register('\\'.$module.'\ServiceProvider');
            }
        });
    }

    /**
     * Bootstrap the module events.
     * @return void
     */
    public function boot()
    {
        // Boot extensions
        parent::boot('system');

        ExtensionManager::instance()->initializeExtensions();

        $this->updateTimezone();
        $this->extendValidator();

        $this->addTranslationDriver();
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

    protected function updateTimezone()
    {
        date_default_timezone_set(Setting::get('timezone', Config::get('app.timezone', 'UTC')));
    }

    /**
     * Register singletons
     */
    protected function registerSingletons()
    {
        App::singleton('admin.helper', function () {
            return new AdminHelper;
        });

        App::singleton('admin.auth', function () {
            return new User;
        });

        App::singleton('auth', function () {
            return new Customer;
        });

        App::singleton('assets', function ($app) {
            return new Libraries\Assets($app);
        });

        App::singleton('admin.menu', function ($app) {
            return Navigation::instance();
        });

        App::singleton('admin.template', function ($app) {
            return new Template;
        });

        App::singleton('country', function ($app) {
            $country = new Libraries\Country;

            $country->setDefaultFormat("{address_1}\n{address_2}\n{city} {postcode}\n{state}\n{country}", [
                '{address_1}', '{address_2}', '{city}', '{postcode}', '{state}', '{country}',
            ]);

            return $country;
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
            $handler = new ErrorHandler;

            return $handler->handleException($exception);
        });
    }

    /**
     * Extends the validator with custom rules
     */
    protected function extendValidator()
    {
        Validator::extend('trim', function ($attribute, $value, $parameters, $validator) {
            return trim($value);
        });

        Validator::extend('valid_date', function ($attribute, $value, $parameters, $validator) {
            return !(!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $value)
                AND !preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $value));
        });

        Validator::extend('valid_time', function ($attribute, $value, $parameters, $validator) {
            return !(!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $value)
                AND !preg_match('/^(1[012]|[1-9]):[0-5][0-9](\s)?(?i)(am|pm)$/', $value));
        });
    }

    protected function registerMailer()
    {
        Event::listen('mailer.beforeRegister', function () {
            Settings_model::applyMailerConfigValues();
        });

        Event::listen('mailer.beforeAddContent', function ($mailer, $message, $view, $data) {
            Mail_templates_model::addContentToMailer($message, $view, $data);
            return false;
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

    protected function addTranslationDriver()
    {
        if ($this->app->hasDatabase()) {
            $this->app['translation.loader']->addDriver(Database::class);
        }
    }

    protected function registerCurrency()
    {
        $this->app['config']->set('currency.default', setting('default_currency_code'));
    }
}