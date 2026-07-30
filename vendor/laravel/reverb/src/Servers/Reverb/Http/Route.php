<?php

namespace Laravel\Reverb\Servers\Reverb\Http;

use Illuminate\Support\Arr;
use Symfony\Component\Routing\Loader\Configurator\Traits\RouteTrait;
use Symfony\Component\Routing\Route as BaseRoute;

class Route
{
    use RouteTrait;

    /**
     * Create a new route instance.
     */
    public function __construct(string $path)
    {
        $this->route = new BaseRoute($path);
    }

    /**
     * Create a new `GET` route.
     */
    public static function get(string $path, callable $action): BaseRoute
    {
        return static::route($path, 'GET', $action);
    }

    /**
     * Create a new `POST` route.
     */
    public static function post($path, callable $action): BaseRoute
    {
        return static::route($path, 'POST', $action);
    }

    /**
     * Create a new `PUT` route.
     */
    public static function put($path, callable $action): BaseRoute
    {
        return static::route($path, 'PUT', $action);
    }

    /**
     * Create a new `PATCH` route.
     */
    public static function patch($path, callable $action): BaseRoute
    {
        return static::route($path, 'PATCH', $action);
    }

    /**
     * Create a new `DELETE` route.
     */
    public static function delete($path, callable $action): BaseRoute
    {
        return static::route($path, 'DELETE', $action);
    }

    /**
     * Create a new `HEAD` route.
     */
    public static function head($path, callable $action): BaseRoute
    {
        return static::route($path, 'HEAD', $action);
    }

    /**
     * Create a new `CONNECT` route.
     */
    public static function connect($path, callable $action): BaseRoute
    {
        return static::route($path, 'CONNECT', $action);
    }

    /**
     * Create a new `OPTIONS` route.
     */
    public static function options($path, callable $action): BaseRoute
    {
        return static::route($path, 'OPTIONS', $action);
    }

    /**
     * Create a new `TRACE` route.
     */
    public static function trace($path, callable $action): BaseRoute
    {
        return static::route($path, 'TRACE', $action);
    }

    /**
     * Create a new route.
     */
    protected static function route(string $path, string|array $methods, callable $action): BaseRoute
    {
        $route = (new static($path))
            ->methods(Arr::wrap($methods))
            ->controller($action);

        return $route->route;
    }
}
