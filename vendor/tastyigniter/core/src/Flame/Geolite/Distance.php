<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Exception\GeoliteException;
use Igniter\Flame\Geolite\Model\Ellipsoid;
use Override;

class Distance implements DistanceInterface
{
    /**
     * The origin coordinate.
     */
    protected ?CoordinatesInterface $from = null;

    /**
     * The destination coordinate.
     */
    protected ?CoordinatesInterface $to = null;

    /**
     * The user unit.
     */
    protected ?string $unit = null;

    protected array $data = [];

    #[Override]
    public function setFrom(CoordinatesInterface $from): self
    {
        $this->from = $from;

        return $this;
    }

    #[Override]
    public function getFrom(): CoordinatesInterface
    {
        return $this->from;
    }

    #[Override]
    public function setTo(CoordinatesInterface $to): self
    {
        $this->to = $to;

        return $this;
    }

    #[Override]
    public function getTo(): CoordinatesInterface
    {
        return $this->to;
    }

    #[Override]
    public function in(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    #[Override]
    public function getUnit(): string
    {
        return $this->unit;
    }

    #[Override]
    public function withData(string $name, mixed $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    #[Override]
    public function getData(string $name, mixed $default = null): mixed
    {
        if (!array_key_exists($name, $this->data)) {
            return $default;
        }

        return $this->data[$name];
    }

    /**
     * Returns the approximate flat distance between two coordinates
     * using Pythagoras’ theorem which is not very accurate.
     * @see http://en.wikipedia.org/wiki/Pythagorean_theorem
     * @see http://en.wikipedia.org/wiki/Equirectangular_projection
     */
    public function flat(): int|float
    {
        Ellipsoid::checkCoordinatesEllipsoid($this->from, $this->to);

        $latA = deg2rad($this->from->getLatitude());
        $lngA = deg2rad($this->from->getLongitude());
        $latB = deg2rad($this->to->getLatitude());
        $lngB = deg2rad($this->to->getLongitude());

        $x = ($lngB - $lngA) * cos(($latA + $latB) / 2);
        $y = $latB - $latA;

        $sqrt = sqrt(($x * $x) + ($y * $y));

        return $this->convertToUserUnit($sqrt * $this->from->getEllipsoid()->getA());
    }

    /**
     * Returns the approximate distance between two coordinates
     * using the spherical trigonometry called Great Circle Distance.
     * @see http://www.ga.gov.au/earth-monitoring/geodesy/geodetic-techniques/distance-calculation-algorithms.html#circle
     * @see http://en.wikipedia.org/wiki/Cosine_law
     */
    public function greatCircle(): int|float
    {
        Ellipsoid::checkCoordinatesEllipsoid($this->from, $this->to);

        $latA = deg2rad($this->from->getLatitude());
        $lngA = deg2rad($this->from->getLongitude());
        $latB = deg2rad($this->to->getLatitude());
        $lngB = deg2rad($this->to->getLongitude());

        $degrees = acos(sin($latA)
            * sin($latB)
            + cos($latA)
            * cos($latB)
            * cos($lngB - $lngA),
        );

        return $this->convertToUserUnit($degrees * $this->from->getEllipsoid()->getA());
    }

    /**
     * Returns the approximate sea level great circle (Earth) distance between
     * two coordinates using the Haversine formula which is accurate to around 0.3%.
     * @see http://www.movable-type.co.uk/scripts/latlong.html
     */
    #[Override]
    public function haversine(): int|float
    {
        Ellipsoid::checkCoordinatesEllipsoid($this->from, $this->to);

        $latA = deg2rad($this->from->getLatitude());
        $lngA = deg2rad($this->from->getLongitude());
        $latB = deg2rad($this->to->getLatitude());
        $lngB = deg2rad($this->to->getLongitude());

        $dLat = $latB - $latA;
        $dLon = $lngB - $lngA;

        $a = sin($dLat / 2) * sin($dLat / 2) + cos($latA) * cos($latB) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $this->convertToUserUnit($this->from->getEllipsoid()->getA() * $c);
    }

    /**
     * Returns geodetic distance between between two coordinates using Vincenty inverse
     * formula for ellipsoids which is accurate to within 0.5mm.
     * @see http://www.movable-type.co.uk/scripts/latlong-vincenty.html
     */
    public function vincenty(): int|float
    {
        Ellipsoid::checkCoordinatesEllipsoid($this->from, $this->to);

        $a = $this->from->getEllipsoid()->getA();
        $b = $this->from->getEllipsoid()->getB();
        $f = 1 / $this->from->getEllipsoid()->getInvF();

        $lL = deg2rad($this->to->getLongitude() - $this->from->getLongitude());
        $u1 = atan((1 - $f) * tan(deg2rad($this->from->getLatitude())));
        $u2 = atan((1 - $f) * tan(deg2rad($this->to->getLatitude())));

        $sinU1 = sin($u1);
        $cosU1 = cos($u1);
        $sinU2 = sin($u2);
        $cosU2 = cos($u2);

        $lambda = $lL;
        $iterLimit = 100;

        do {
            $sinLambda = sin($lambda);
            $cosLambda = cos($lambda);
            $sinSigma = sqrt(($cosU2 * $sinLambda) * ($cosU2 * $sinLambda) +
                ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda) * ($cosU1 * $sinU2 - $sinU1 * $cosU2 * $cosLambda));

            if ($sinSigma === 0.0) {
                return 0.0; // co-incident points
            }

            $cosSigma = $sinU1 * $sinU2 + $cosU1 * $cosU2 * $cosLambda;
            $sigma = atan2($sinSigma, $cosSigma);
            $sinAlpha = $cosU1 * $cosU2 * $sinLambda / $sinSigma;
            $cosSqAlpha = 1 - $sinAlpha * $sinAlpha;
            $cos2SigmaM = $cosSqAlpha !== 0.0 ? $cosSigma - 2 * $sinU1 * $sinU2 / $cosSqAlpha : 0.0;
            $cC = $f / 16 * $cosSqAlpha * (4 + $f * (4 - 3 * $cosSqAlpha));
            $lambdaP = $lambda;
            $lambda = $lL + (1 - $cC) * $f * $sinAlpha * ($sigma + $cC * $sinSigma *
                    ($cos2SigmaM + $cC * $cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM)));
        } while (abs($lambda - $lambdaP) > 1e-12 && --$iterLimit > 0);

        if ($iterLimit === 0) {
            throw new GeoliteException('Vincenty formula failed to converge !');
        }

        $uSq = $cosSqAlpha * ($a * $a - $b * $b) / ($b * $b);
        $aA = 1 + $uSq / 16384 * (4096 + $uSq * (-768 + $uSq * (320 - 175 * $uSq)));
        $bB = $uSq / 1024 * (256 + $uSq * (-128 + $uSq * (74 - 47 * $uSq)));
        $deltaSigma = $bB * $sinSigma * ($cos2SigmaM + $bB / 4 * ($cosSigma * (-1 + 2 * $cos2SigmaM * $cos2SigmaM) -
                    $bB / 6 * $cos2SigmaM * (-3 + 4 * $sinSigma * $sinSigma) * (-3 + 4 * $cos2SigmaM * $cos2SigmaM)));
        $s = $b * $aA * ($sigma - $deltaSigma);

        return $this->convertToUserUnit($s);
    }

    /**
     * Converts results in meters to user's unit (if any).
     * The default returned value is in meters.
     */
    public function convertToUserUnit(int|float $meters): int|float
    {
        return match ($this->unit) {
            Geolite::KILOMETER_UNIT => $meters / 1000,
            Geolite::MILE_UNIT => $meters / Geolite::METERS_PER_MILE,
            Geolite::FOOT_UNIT => $meters / Geolite::FEET_PER_METER,
            default => $meters,
        };
    }
}
