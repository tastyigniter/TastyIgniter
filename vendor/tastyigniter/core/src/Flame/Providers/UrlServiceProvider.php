<?php

declare(strict_types=1);

namespace Igniter\Flame\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class UrlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        $this->app->booted(function() {
            $this->forceUrlGeneratorPolicy();
        });
    }

    /**
     * Controls how URL links are generated throughout the application.
     *
     * detect   - detect hostname and use the current schema
     * secure   - detect hostname and force HTTPS schema
     * insecure - detect hostname and force HTTP schema
     * force    - force hostname and schema using app.url config value
     */
    public function forceUrlGeneratorPolicy(): void
    {
        $policy = $this->app['config']->get('igniter-system.urlPolicy', 'detect');

        switch (strtolower((string)$policy)) {
            case 'force':
                $appUrl = $this->app['config']->get('app.url');
                $schema = Str::startsWith($appUrl, 'http://') ? 'http' : 'https';
                $this->app['url']->forceRootUrl($appUrl);
                $this->app['url']->forceScheme($schema);
                break;

            case 'insecure':
                $this->app['url']->forceScheme('http');
                break;

            case 'secure':
                $this->app['url']->forceScheme('https');
                break;
        }
    }
}
