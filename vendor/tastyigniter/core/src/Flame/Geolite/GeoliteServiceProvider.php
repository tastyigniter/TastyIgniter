<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use GuzzleHttp\Client;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Override;

class GeoliteServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton('geocoder', fn($app): Geocoder => new Geocoder($app));

        $this->app->singleton('geolite', fn(): Geolite => new Geolite);

        $this->app->singleton('geocoder.client', fn(): Client => new Client);
        $this->app->alias('geocoder', Geocoder::class);
        $this->app->alias('geolite', Geolite::class);

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Geocoder', Facades\Geocoder::class);
        $aliasLoader->alias('Geolite', Facades\Geolite::class);
    }
}
