<?php

namespace System;

use Admin\Classes\Navigation;
use Admin\Classes\Template;
use Admin\Classes\User;
use Admin\Helpers\Admin as AdminHelper;
use App;
use Config;
use Event;
use Igniter\Flame\ActivityLog\ActivityLogServiceProvider;
use Igniter\Flame\Currency\CurrencyServiceProvider;
use Igniter\Flame\Foundation\Providers\AppServiceProvider;
use Igniter\Flame\Geolite\GeoliteServiceProvider;
use Igniter\Flame\Pagic\PagicServiceProvider;
use Igniter\Flame\Support\HelperServiceProvider;
use Igniter\Flame\Translation\Drivers\Database;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Main\Classes\Customer;
use Request;
use Setting;
use System\Classes\ErrorHandler;
use System\Classes\ExtensionManager;
use System\Libraries\Assets;
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

        $this->registerProviders();
        $this->registerSingletons();

        // Register all extensions
        ExtensionManager::instance()->registerExtensions();

        $this->registerConsole();
        $this->registerErrorHandler();
        $this->registerMailer();
        $this->registerPaginator();
        $this->registerAssets();

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

        $this->defineEloquentMorphMaps();

        ExtensionManager::instance()->bootExtensions();

        $this->updateTimezone();
        $this->setConfiguration();
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

        App::singleton('assets', function () {
            return new Libraries\Assets();
        });

        App::singleton('admin.menu', function ($app) {
            return new Navigation('~/app/admin/views/_partials/');
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

        App::instance('path.uploads', base_path(Config::get('system.assets.media.path', 'assets/media/uploads')));
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

        // Allow system based cache clearing
        Event::listen('cache:cleared', function () {
            \System\Helpers\CacheHelper::clearInternal();
        });

        foreach (
            [
                'igniter.util' => Console\Commands\IgniterUtil::class,
                'igniter.up' => Console\Commands\IgniterUp::class,
                'igniter.down' => Console\Commands\IgniterDown::class,
                'igniter.install' => Console\Commands\IgniterInstall::class,
                'igniter.update' => Console\Commands\IgniterUpdate::class,
                'extension.install' => Console\Commands\ExtensionInstall::class,
                'extension.refresh' => Console\Commands\ExtensionRefresh::class,
                'extension.remove' => Console\Commands\ExtensionRemove::class,
                'theme.install' => Console\Commands\ThemeInstall::class,
                'theme.remove' => Console\Commands\ThemeRemove::class,
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

            return FALSE;
        });
    }

    protected function registerPaginator()
    {
        Paginator::defaultView('system::_partials/pagination/default');
        Paginator::defaultSimpleView('system::_partials/pagination/simple_default');

        Paginator::currentPathResolver(function () {
            return url()->current();
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

    protected function setConfiguration()
    {
        Event::listen('currency.beforeRegister', function () {
            app('config')->set('currency.default', setting('default_currency_code'));
        });

        $this->app->resolving('geocoder', function ($geocoder, $app) {
            $app['config']->set('geocoder.default', setting('default_geocoder'));

            $region = $app['country']->getCountryCodeById(setting('country_id'));
            $app['config']->set('geocoder.providers.google.region', $region);
            $app['config']->set('geocoder.providers.nominatim.region', $region);

            $app['config']->set('geocoder.providers.google.apiKey', setting('maps_api_key'));
        });
    }

    protected function registerAssets()
    {
        Assets::registerCallback(function (Assets $manager) {
            $manager->registerSourcePath(app_path('system/assets'));

            // System asset bundles
            $manager->registerBundle('scss',
                '~/app/system/assets/ui/scss/flame.scss',
                '~/app/system/assets/ui/flame.css'
            );
            $manager->registerBundle('js', [
                '~/node_modules/jquery/dist/jquery.min.js',
                '~/node_modules/popper.js/dist/umd/popper.min.js',
                '~/node_modules/bootstrap/dist/js/bootstrap.min.js',
                '~/app/system/assets/ui/js/vendor/waterfall.min.js',
                '~/app/system/assets/ui/js/vendor/transition.js',
                '~/app/system/assets/ui/js/app.js',
                '~/app/system/assets/ui/js/flashmessage.js',
                '~/app/system/assets/ui/js/toggler.js',
                '~/app/system/assets/ui/js/trigger.js',
            ], '~/app/system/assets/ui/flame.js');

            // Admin asset bundles
            $manager->registerBundle('scss', '~/app/admin/assets/scss/admin.scss');
            $manager->registerBundle('js', [
                '~/node_modules/js-cookie/src/js.cookie.js',
                '~/node_modules/select2/dist/js/select2.min.js',
                '~/node_modules/metismenu/dist/metisMenu.min.js',
                '~/app/admin/assets/js/src/app.js',
            ], '~/app/admin/assets/js/admin.js');

        });
    }

    protected function defineEloquentMorphMaps()
    {
        Relation::morphMap([
            'activities' => 'System\Models\Activities_model',
            'countries' => 'System\Models\Countries_model',
            'currencies' => 'System\Models\Currencies_model',
            'extensions' => 'System\Models\Extensions_model',
            'languages' => 'System\Models\Languages_model',
            'mail_layouts' => 'System\Models\Mail_layouts_model',
            'mail_templates' => 'System\Models\Mail_templates_model',
            'message_meta' => 'System\Models\Message_meta_model',
            'messages' => 'System\Models\Messages_model',
            'pages' => 'System\Models\Pages_model',
            'permissions' => 'System\Models\Permissions_model',
            'settings' => 'System\Models\Settings_model',
            'themes' => 'System\Models\Themes_model',
        ]);
    }

    protected function registerProviders()
    {
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(PagicServiceProvider::class);
        $this->app->register(ActivityLogServiceProvider::class);
        $this->app->register(CurrencyServiceProvider::class);
        $this->app->register(GeoliteServiceProvider::class);
    }
}