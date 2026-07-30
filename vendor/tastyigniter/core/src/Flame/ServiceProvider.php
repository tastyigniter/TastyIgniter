<?php

declare(strict_types=1);

namespace Igniter\Flame;

use Igniter\Flame\Assetic\AsseticServiceProvider;
use Igniter\Flame\Composer\Manager as ComposerManaer;
use Igniter\Flame\Currency\CurrencyServiceProvider;
use Igniter\Flame\Database\DatabaseServiceProvider;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\AjaxException;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\ErrorHandler;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Filesystem\Filesystem;
use Igniter\Flame\Filesystem\FilesystemServiceProvider;
use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Flash\FlashServiceProvider;
use Igniter\Flame\Geolite\GeoliteServiceProvider;
use Igniter\Flame\Html\FormFacade;
use Igniter\Flame\Html\HtmlFacade;
use Igniter\Flame\Html\HtmlServiceProvider;
use Igniter\Flame\Mail\MailServiceProvider;
use Igniter\Flame\Pagic\PagicServiceProvider;
use Igniter\Flame\Providers\ConsoleSupportServiceProvider;
use Igniter\Flame\Providers\MacroServiceProvider;
use Igniter\Flame\Providers\UrlServiceProvider;
use Igniter\Flame\Scaffold\ScaffoldServiceProvider;
use Igniter\Flame\Support\ClassLoader;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Flame\Support\MediaUploadValidator;
use Igniter\Flame\Translation\Middleware\Localization;
use Igniter\Flame\Translation\TranslationServiceProvider;
use Igniter\System\Classes\PackageManifest;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\View\FileViewFinder;
use Override;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $root = __DIR__.'/../..';

    protected $providers = [
        AsseticServiceProvider::class,
        CurrencyServiceProvider::class,
        ConsoleSupportServiceProvider::class,
        DatabaseServiceProvider::class,
        FilesystemServiceProvider::class,
        FlashServiceProvider::class,
        GeoliteServiceProvider::class,
        HtmlServiceProvider::class,
        MailServiceProvider::class,
        MacroServiceProvider::class,
        PagicServiceProvider::class,
        ScaffoldServiceProvider::class,
        TranslationServiceProvider::class,
        UrlServiceProvider::class,

        \Igniter\System\ServiceProvider::class,
    ];

    protected $configFiles = [
        'currency', 'geocoder', 'routes', 'system',
    ];

    #[Override]
    public function register(): void
    {
        $this->app->singleton(Igniter::class);

        $this->mergeConfigFiles();

        $this->loadTranslationsFrom($this->root.'/resources/lang/', 'igniter');

        $this->bindPathsInContainer();

        $this->app->make(Router::class)->middlewareGroup('igniter', [
            Localization::class,
        ]);

        $this->registerSingletons();
        $this->registerProviders();
        $this->registerFacadeAliases();
        $this->registerErrorHandler();
        $this->registerErrorViewPaths();
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigFiles();

            $this->publishes([
                $this->root.'/resources/lang' => lang_path('/vendor/igniter'),
            ], 'igniter-translations');
        }
    }

    protected function mergeConfigFiles()
    {
        collect($this->configFiles)->each(function(string $config) {
            $this->mergeConfigFrom($this->root.'/config/'.$config.'.php', 'igniter-'.$config);
        });
    }

    protected function publishConfigFiles()
    {
        collect($this->configFiles)->each(function(string $config) {
            $this->publishes([$this->root.'/config/'.$config.'.php' => config_path('igniter-'.$config.'.php')], 'igniter-config');
        });
    }

    protected function registerProviders()
    {
        collect($this->providers)->each(function($provider) {
            $this->app->register($provider);
        });
    }

    protected function registerSingletons()
    {
        $this->app->singleton(PackageManifest::class, fn(): PackageManifest => new PackageManifest(
            new Filesystem,
            $this->app->basePath(),
            Igniter::getCachedAddonsPath(),
        ));

        $this->app->singleton(ComposerManaer::class, fn(): ComposerManaer => new ComposerManaer(
            base_path(),
            storage_path('igniter/composer'),
        ));

        $this->app->singleton(MediaUploadValidator::class);

        $this->app->instance(ClassLoader::class, $loader = new ClassLoader(
            new Filesystem,
            $this->app->basePath(),
            Igniter::getCachedClassesPath(),
        ));

        $loader->register();
        $loader->addDirectories(['extensions']);

        $this->app['events']->listen(RouteMatched::class, function() use ($loader) {
            $loader->build();
        });
    }

    protected function registerFacadeAliases()
    {
        $loader = AliasLoader::getInstance();

        foreach ([
            'Flash' => Flash::class,
            'Form' => FormFacade::class,
            'Html' => HtmlFacade::class,
            'Model' => Model::class,
            'SystemException' => SystemException::class,
            'ApplicationException' => ApplicationException::class,
            'AjaxException' => AjaxException::class,
        ] as $alias => $class) {
            $loader->alias($alias, $class);
        }
    }

    /*
     * Error handling for uncaught Exceptions
     */
    protected function registerErrorHandler()
    {
        $this->callAfterResolving(ExceptionHandler::class, function($handler) {
            new ErrorHandler($handler);
        });
    }

    protected function registerErrorViewPaths()
    {
        Event::listen('exception.beforeRender', function($exception, $httpCode, $request) {
            /** @var FileViewFinder $finder */
            $finder = view()->getFinder();
            $themeViewPaths = array_get($finder->getHints(), 'igniter.system', []);
            config()->set('view.paths', array_merge($themeViewPaths, config('view.paths')));
        });
    }

    protected function bindPathsInContainer()
    {
        $this->app->instance('path.themes', Igniter::themesPath());
        $this->app->instance('path.temp', Igniter::tempPath());
    }
}
