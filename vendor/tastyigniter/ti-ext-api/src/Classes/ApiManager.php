<?php

declare(strict_types=1);

namespace Igniter\Api\Classes;

use Igniter\Api\Models\Resource;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Sanctum\Contracts\HasAbilities;

class ApiManager
{
    protected $resources;

    /**
     * The access token the user is using for the current request.
     *
     * @var HasAbilities
     */
    protected $accessToken;

    public function getResources()
    {
        if (is_null($this->resources)) {
            $this->loadResources();
        }

        return $this->resources;
    }

    public function getResource($endpoint)
    {
        return array_get($this->getResources(), $endpoint, []);
    }

    public function getCurrentResource()
    {
        $currentResourceName = Str::before(Str::after(Route::currentRouteName(), 'api.'), '.');

        return $this->getResource($currentResourceName);
    }

    public function getCurrentAction()
    {
        return Str::afterLast(Route::currentRouteAction(), '@');
    }

    protected function loadResources()
    {
        Resource::syncAll();

        $resources = Resource::all()->mapWithKeys(function(Resource $resource): array {
            $resourceObj = (object)[
                'endpoint' => $resource->endpoint,
                'controller' => $resource->controller,
                'options' => array_merge($resource->meta, [
                    'only' => $resource->getAvailableActions(),
                ]),
            ];

            return [$resource->endpoint => $resourceObj];
        });

        $this->resources = $resources;
    }

    public static function registerRoutes(): void
    {
        if (!Igniter::hasDatabase() || !Schema::hasTable('igniter_api_resources')) {
            return;
        }

        Route::middleware(config('igniter-api.middleware'))
            ->as('igniter.api.')
            ->prefix(config('igniter-api.prefix'))
            ->group(function(Router $router): void {
                foreach (resolve(static::class)->getResources() as $endpoint => $resourceObj) {
                    if (!class_exists((string)$resourceObj->controller)) {
                        continue;
                    }

                    $router->resource($endpoint, $resourceObj->controller, $resourceObj->options);
                }
            });
    }
}
