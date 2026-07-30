<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Facades;

use Closure;
use Igniter\Flame\Geolite\Contracts\AbstractProvider;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static \Igniter\Flame\Geolite\Geocoder limit(int $limit)
 * @method static \Igniter\Flame\Geolite\Geocoder locale(string $locale)
 * @method static Collection geocode(string $address)
 * @method static Collection reverse(int | float $latitude, int | float $longitude)
 * @method static Collection geocodeQuery(GeoQueryInterface $query)
 * @method static Collection reverseQuery(GeoQueryInterface $query)
 * @method static AbstractProvider using(string $name)
 * @method static AbstractProvider driver(string $driver = null)
 * @method static AbstractProvider makeProvider(string $name)
 * @method static string getDefaultDriver()
 * @method static \Igniter\Flame\Geolite\Geocoder extend(string $driver, Closure $callback)
 * @method static array getDrivers()
 * @method static array getLogs()
 * @method static Container getContainer()
 * @method static \Igniter\Flame\Geolite\Geocoder setContainer(Container $container)
 * @method static \Igniter\Flame\Geolite\Geocoder forgetDrivers()
 *
 * @see \Igniter\Flame\Geolite\Geocoder
 */
class Geocoder extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'geocoder';
    }
}
