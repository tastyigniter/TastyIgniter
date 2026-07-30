<?php

declare(strict_types=1);

namespace Igniter\System;

use Igniter\Flame\Flash\FlashBag;
use Igniter\Flame\Providers\AppServiceProvider;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Flame\Support\LogViewer;
use Igniter\Main\Models\Theme;
use Igniter\System\Actions\ModelAction;
use Igniter\System\Actions\SettingsModel;
use Igniter\System\Classes\ComponentManager;
use Igniter\System\Classes\ControllerAction;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Classes\HubManager;
use Igniter\System\Classes\LanguageManager;
use Igniter\System\Classes\MailManager;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Facades\Assets;
use Igniter\System\Http\Middleware\CheckRequirements;
use Igniter\System\Http\Middleware\PoweredBy;
use Igniter\System\Models\Country;
use Igniter\System\Models\Currency;
use Igniter\System\Models\Extension;
use Igniter\System\Models\Language;
use Igniter\System\Models\MailLayout;
use Igniter\System\Models\MailTemplate;
use Igniter\System\Models\RequestLog;
use Igniter\System\Models\Settings;
use Igniter\System\Providers\ConsoleServiceProvider;
use Igniter\System\Providers\EventServiceProvider;
use Igniter\System\Providers\ExtensionServiceProvider;
use Igniter\System\Providers\FormServiceProvider;
use Igniter\System\Providers\HealthServiceProvider;
use Igniter\System\Providers\MailServiceProvider;
use Igniter\System\Providers\PaginationServiceProvider;
use Igniter\System\Providers\PermissionServiceProvider;
use Igniter\System\Providers\ValidationServiceProvider;
use Igniter\User\Models\Notification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Override;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceProvider extends AppServiceProvider
{
    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->registerSingletons();
        $this->registerFacadeAliases();

        Igniter::loadControllersFrom(igniter_path('src/System/Http/Controllers'), 'Igniter\\System\\Http\\Controllers');

        Route::pushMiddlewareToGroup('igniter', CheckRequirements::class);
        Route::pushMiddlewareToGroup('igniter', PoweredBy::class);

        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(ExtensionServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(MailServiceProvider::class);
        $this->app->register(PaginationServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(ValidationServiceProvider::class);
        $this->app->register(HealthServiceProvider::class);
        $this->app->register(\Igniter\Admin\ServiceProvider::class);
        $this->app->register(\Igniter\Main\ServiceProvider::class);
    }

    /**
     * Bootstrap the module events.
     */
    public function boot(): void
    {
        $this->loadViewsFrom($this->root.'/resources/views/system', 'igniter.system');
        $this->loadAnonymousComponentFrom('igniter.system::_components.', 'igniter.system');
        $this->loadResourcesFrom($this->root.'/resources', 'igniter');

        $this->definePrunableModels();
        $this->defineEloquentMorphMaps();
        $this->resolveFlashSessionKey();
        $this->clearStaticCacheOnTerminate();

        $this->app->booted(fn() => $this->updateTimezone());

        $this->loadCurrencyConfiguration();
        $this->loadLocalizationConfiguration();
        $this->loadGeocoderConfiguration();

        $this->app['events']->listen(MigrationsStarted::class, function() {
            Schema::disableForeignKeyConstraints();
        });

        if (!Igniter::runningInAdmin()) {
            $this->app['events']->listen('exception.beforeRender', function($exception, $httpCode, $request) {
                if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                    RequestLog::createLog();
                }
            });
        }
    }

    protected function updateTimezone()
    {
        date_default_timezone_set(Settings::get('timezone', Config::get('app.timezone', 'UTC')));
    }

    /**
     * Register singletons
     */
    protected function registerSingletons()
    {
        $this->app->singleton('assets', fn(): Libraries\Assets => new Libraries\Assets);

        $this->app->singleton('country', fn($app): Libraries\Country => new Libraries\Country);

        $this->app->instance('path.uploads', base_path(Config::get('igniter-system.assets.media.path', 'assets/media/uploads')));

        $this->app->singleton(Settings::class);
        $this->app->singleton(LogViewer::class);

        $this->app->singleton(ComponentManager::class);
        $this->app->singleton(ExtensionManager::class);
        $this->app->singleton(HubManager::class);
        $this->tapSingleton(LanguageManager::class);
        $this->app->singleton(MailManager::class);
        $this->app->singleton(UpdateManager::class);
    }

    protected function registerFacadeAliases()
    {
        $loader = AliasLoader::getInstance();

        foreach ([
            'Assets' => Assets::class,
            'Country' => Facades\Country::class,
        ] as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }

    protected function defineEloquentMorphMaps()
    {
        Relation::morphMap([
            'countries' => Country::class,
            'currencies' => Currency::class,
            'extensions' => Extension::class,
            'languages' => Language::class,
            'mail_layouts' => MailLayout::class,
            'mail_templates' => MailTemplate::class,
            'settings' => Settings::class,
            'themes' => Theme::class,
        ]);
    }

    protected function loadCurrencyConfiguration()
    {
        Event::listen('currency.beforeRegister', function() {
            app('config')->set('igniter-currency.default', Currency::getDefault()->currency_code ?? 'GBP');
            app('config')->set('igniter-currency.converter', setting('currency_converter.api', 'openexchangerates'));
            app('config')->set('igniter-currency.converters.openexchangerates.apiKey', setting('currency_converter.oer.apiKey'));
            app('config')->set('igniter-currency.converters.fixerio.apiKey', setting('currency_converter.fixerio.apiKey'));
            app('config')->set('igniter-currency.ratesCacheDuration', setting('currency_converter.refreshInterval'));
            app('config')->set('igniter-currency.model', Currency::class);
        });
    }

    protected function loadLocalizationConfiguration()
    {
        $this->app->resolving('translator.localization', function($localization, Application $app) {
            $app['config']->set('localization.locale', Language::getDefault()->code ?? $app['config']['app.locale']);
            $app['config']->set('localization.supportedLocales', params('supported_languages', []) ?: ['en']);
            $app['config']->set('localization.detectBrowserLocale', (bool)setting('detect_language', false));
        });
    }

    protected function loadGeocoderConfiguration()
    {
        $this->app->resolving('geocoder', function($geocoder, Application $app) {
            $app['config']->set('igniter-geocoder.default', setting('default_geocoder', 'nominatim'));

            $region = $app['country']->getCountryCodeById(Country::getDefaultKey());
            $app['config']->set('igniter-geocoder.providers.google.region', $region);
            $app['config']->set('igniter-geocoder.providers.nominatim.region', $region);

            $app['config']->set('igniter-geocoder.providers.google.apiKey', setting('maps_api_key'));
            $app['config']->set('igniter-geocoder.precision', setting('geocoder_boundary_precision', 8));
        });
    }

    protected function resolveFlashSessionKey()
    {
        $this->app->resolving('flash', function(FlashBag $flash) {
            $flash->setSessionKey(Igniter::runningInAdmin() ? 'flash_data_admin' : 'flash_data_main');
        });
    }

    protected function definePrunableModels()
    {
        Igniter::prunableModel([
            Notification::class,
            RequestLog::class,
        ]);
    }

    protected function clearStaticCacheOnTerminate()
    {
        $this->app->terminating(function() {
            Assets::clearInternalCache();
            SettingsModel::clearInternalCache();
            ModelAction::extensionClearCallbacks();
            ControllerAction::extensionClearCallbacks();
            Extendable::clearExtendedClasses();
            Settings::clearInternalCache();
            Language::clearInternalCache();
            Language::clearDefaultModels();
        });
    }
}
