<?php

declare(strict_types=1);

namespace Igniter\Main\Classes;

use Igniter\Flame\Pagic\Router;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Routing\Router as IlluminateRouter;
use Illuminate\Support\Collection;

class RouteRegistrar
{
    public function __construct(protected IlluminateRouter $router) {}

    /**
     * Register routes for admin and frontend.
     */
    public function all(): void
    {
        $this->forAssets();
        $this->forThemePages();
    }

    public function forAssets(): void
    {
        $this->router
            ->namespace('Igniter\System\Http\Controllers')
            ->middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('igniter.main.assets')
            ->prefix(Igniter::uri())
            ->group(function(IlluminateRouter $router) {
                $router->get(config('igniter-routes.assetsCombinerUri', '_assets').'/{asset}', 'AssetController');
            });
    }

    public function forThemePages(): void
    {
        $this->router
            ->middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('igniter.theme.')
            ->prefix(Igniter::uri())
            ->group(function(IlluminateRouter $router) {
                foreach ($this->getThemePageRoutes() as $parts) {
                    $route = $router->pagic($parts['uri'], $parts['route'])
                        ->defaults('_file_', $parts['file']);

                    foreach ($parts['defaults'] ?? [] as $key => $value) {
                        $route->defaults($key, $value);
                    }

                    foreach ($parts['constraints'] ?? [] as $key => $value) {
                        $route->where($key, $value);
                    }
                }

                event('igniter.main.registerRoutes', $router);
            });
    }

    protected function getThemePageRoutes(): array|Collection
    {
        if (Igniter::disableThemeRoutes()) {
            return [];
        }

        return resolve(Router::class)->getRouteMap();
    }
}
