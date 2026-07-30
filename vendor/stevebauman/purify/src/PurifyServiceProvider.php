<?php

namespace Stevebauman\Purify;

use HTMLPurifier_DefinitionCacheFactory;
use Illuminate\Support\ServiceProvider;
use Stevebauman\Purify\Commands\ClearCommand;

class PurifyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/purify.php', 'purify');

        $this->commands(ClearCommand::class);

        $this->app->singleton('purify', function ($app) {
            if ($cache = config('purify.serializer.cache')) {
                HTMLPurifier_DefinitionCacheFactory::instance()->register($cache, $cache);
            }

            return new PurifyManager($app);
        });
    }

    /**
     * Register the publishable configuration.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/purify.php' => config_path('purify.php'),
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['purify'];
    }
}
