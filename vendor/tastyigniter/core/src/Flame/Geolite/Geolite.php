<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\CircleInterface;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Contracts\PolygonInterface;
use Igniter\Flame\Geolite\Contracts\VertexInterface;
use Igniter\Flame\Geolite\Model\Coordinates;

class Geolite
{
    /**
     * The ratio meters per mile.
     */
    public const float METERS_PER_MILE = 1609.344;

    /**
     * The ratio feet per meter.
     */
    public const float FEET_PER_METER = 0.3048;

    /**
     * The kilometer unit.
     */
    public const string KILOMETER_UNIT = 'km';

    /**
     * The mile unit.
     */
    public const string MILE_UNIT = 'mi';

    /**
     * The feet unit.
     */
    public const string FOOT_UNIT = 'ft';

    public function distance(): DistanceInterface
    {
        return new Distance;
    }

    public function circle(array|CoordinatesInterface $coordinate, int $radius): CircleInterface
    {
        return (new Circle($coordinate, $radius))
            ->setPrecision(config('igniter-geocoder.precision', 8));
    }

    public function polygon(array|CoordinatesInterface $coordinates): PolygonInterface
    {
        return (new Polygon($coordinates))
            ->setPrecision(config('igniter-geocoder.precision', 8));
    }

    public function vertex(): VertexInterface
    {
        return (new Vertex)
            ->setPrecision(config('igniter-geocoder.precision', 8));
    }

    public function coordinates(int|float $latitude, int|float $longitude): CoordinatesInterface
    {
        return (new Coordinates($latitude, $longitude))
            ->setPrecision(config('igniter-geocoder.precision', 8));
    }

    public function addressMatch(array $components): AddressMatch
    {
        return new AddressMatch($components);
    }
}
