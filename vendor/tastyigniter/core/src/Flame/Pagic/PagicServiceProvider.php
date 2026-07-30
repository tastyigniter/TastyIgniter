<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use Igniter\Flame\Pagic\Cache\FileSystem as FileCache;
use Igniter\Flame\Pagic\Source\SourceResolver;
use Illuminate\Support\ServiceProvider;
use Override;

/**
 * Class PagicServiceProvider
 */
class PagicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        Model::setSourceResolver($this->app['pagic.resolver']);

        Model::setEventDispatcher($this->app['events']);

        Model::setCacheManager($this->app['cache']);

        $this->app->terminating(function() {
            Model::clearExtendedClasses();
            Model::clearBootedModels();
            Finder::clearInternalCache();
        });
    }

    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton('pagic.resolver', fn(): SourceResolver => new SourceResolver);

        $this->app->singleton(Router::class);

        $this->app->singleton(FileCache::class, fn(): FileCache => new FileCache(config('igniter-pagic.parsedTemplateCachePath')));

        $this->app->singleton(TemplateSandbox::class);

        $this->app->alias('pagic', Environment::class);

        $this->app->singleton('pagic', fn(): Environment => new Environment(new Loader, [
            'debug' => config('app.debug', false),
            'cache' => new FileCache(config('view.compiled')),
            'templateClass' => Template::class,
        ]));
    }
}
