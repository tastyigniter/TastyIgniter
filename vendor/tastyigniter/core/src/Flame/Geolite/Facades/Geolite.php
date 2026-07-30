<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Facades;

use Igniter\Flame\Geolite\AddressMatch;
use Igniter\Flame\Geolite\Contracts\CircleInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Contracts\PolygonInterface;
use Igniter\Flame\Geolite\Contracts\VertexInterface;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static DistanceInterface distance()
 * @method static CircleInterface circle(CoordinatesInterface | array $coordinate, int $radius)
 * @method static PolygonInterface polygon(CoordinatesInterface | array $coordinates)
 * @method static VertexInterface vertex()
 * @method static CoordinatesInterface coordinates(int | float | null $latitude, int | float | null $longitude)
 * @method static AddressMatch addressMatch(array $components)
 *
 * @see \Igniter\Flame\Geolite\Geolite
 */
class Geolite extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'geolite';
    }
}
