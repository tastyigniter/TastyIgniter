<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency;

use Igniter\Flame\Currency\Console\Cleanup;
use Igniter\Flame\Currency\Console\Update;
use Igniter\Flame\Currency\Middleware\CurrencyMiddleware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Override;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->registerMiddlewareAlias();

        $this->registerCurrency();
        $this->registerCurrencyCommands();

        $this->registerConverter();
    }

    protected function registerMiddlewareAlias()
    {
        $this->app[Router::class]->aliasMiddleware(
            'currency', CurrencyMiddleware::class,
        );
    }

    /**
     * Register currency provider.
     */
    public function registerCurrency(): void
    {
        $this->app->singleton('currency', function(Application $app): Currency {
            $this->app['events']->dispatch('currency.beforeRegister', [$this]);

            return new Currency(
                $app->config['igniter-currency'] ?? [],
                $app['cache'],
            );
        });

        $this->app->alias('currency', Currency::class);
    }

    /**
     * Register currency commands.
     */
    public function registerCurrencyCommands(): void
    {
        $this->commands([
            Cleanup::class,
            Update::class,
        ]);
    }

    protected function registerConverter()
    {
        $this->app->singleton('currency.converter', fn($app): Converter => new Converter($app));
    }
}
