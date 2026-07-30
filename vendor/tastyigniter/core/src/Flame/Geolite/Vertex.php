<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\VertexInterface;
use Igniter\Flame\Geolite\Model\Coordinates;
use Override;

class Vertex implements VertexInterface
{
    /**
     * The origin coordinate.
     */
    protected CoordinatesInterface $from;

    /**
     * The destination coordinate.
     */
    protected CoordinatesInterface $to;

    protected ?float $gradient = null;

    protected ?float $ordinateIntercept = null;

    protected int $precision = 8;

    /**
     * The cardinal points / directions (the four cardinal directions,
     * the four ordinal directions, plus eight further divisions).
     */
    public static array $cardinalPoints = [
        'N', 'NNE', 'NE', 'ENE',
        'E', 'ESE', 'SE', 'SSE',
        'S', 'SSW', 'SW', 'WSW',
        'W', 'WNW', 'NW', 'NNW',
        'N',
    ];

    #[Override]
    public function setFrom(CoordinatesInterface $from): VertexInterface
    {
        $this->from = $from;

        if (empty($this->to) || ($this->to->getLatitude() - $this->from->getLatitude()) === 0) {
            return $this;
        }

        if ($this->to->getLatitude() !== $this->from->getLatitude()) {
            $this->gradient = ($this->to->getLongitude() - $this->from->getLongitude()) / ($this->to->getLatitude() - $this->from->getLatitude());
            $this->ordinateIntercept = $this->from->getLongitude() - $this->from->getLatitude() * $this->gradient;
        } else {
            $this->gradient = null;
            $this->ordinateIntercept = null;
        }

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

        if (empty($this->from) || ($this->to->getLatitude() - $this->from->getLatitude()) === 0) {
            return $this;
        }

        if ($this->to->getLatitude() !== $this->from->getLatitude()) {
            $this->gradient = ($this->to->getLongitude() - $this->from->getLongitude()) / ($this->to->getLatitude() - $this->from->getLatitude());
            $this->ordinateIntercept = $this->from->getLongitude() - $this->from->getLatitude() * $this->gradient;
        } else {
            $this->gradient = null;
            $this->ordinateIntercept = null;
        }

        return $this;
    }

    #[Override]
    public function getTo(): CoordinatesInterface
    {
        return $this->to;
    }

    #[Override]
    public function getGradient(): ?float
    {
        return $this->gradient;
    }

    #[Override]
    public function getOrdinateIntercept(): ?float
    {
        return $this->ordinateIntercept;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }

    public function setPrecision(int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Returns the initial bearing from the origin coordinate
     * to the destination coordinate in degrees.
     */
    public function initialBearing(): int|float
    {
        $latA = deg2rad($this->from->getLatitude());
        $latB = deg2rad($this->to->getLatitude());
        $dLng = deg2rad($this->to->getLongitude() - $this->from->getLongitude());

        $y = sin($dLng) * cos($latB);
        $x = cos($latA) * sin($latB) - sin($latA) * cos($latB) * cos($dLng);

        return (rad2deg(atan2($y, $x)) + 360) % 360;
    }

    /**
     * Returns the final bearing from the origin coordinate
     * to the destination coordinate in degrees.
     */
    public function finalBearing(): int|float
    {
        $latA = deg2rad($this->to->getLatitude());
        $latB = deg2rad($this->from->getLatitude());
        $dLng = deg2rad($this->from->getLongitude() - $this->to->getLongitude());

        $y = sin($dLng) * cos($latB);
        $x = cos($latA) * sin($latB) - sin($latA) * cos($latB) * cos($dLng);

        return (float)((rad2deg(atan2($y, $x)) + 360) % 360 + 180) % 360;
    }

    /**
     * Returns the initial cardinal point / direction from the origin coordinate to
     * the destination coordinate.
     * @see http://en.wikipedia.org/wiki/Cardinal_direction
     */
    public function initialCardinal(): string
    {
        return static::$cardinalPoints[(int)round($this->initialBearing() / 22.5)];
    }

    /**
     * Returns the final cardinal point / direction from the origin coordinate to
     * the destination coordinate.
     * @see http://en.wikipedia.org/wiki/Cardinal_direction
     */
    public function finalCardinal(): string
    {
        return static::$cardinalPoints[(int)round($this->finalBearing() / 22.5)];
    }

    /**
     * Returns the half-way point / coordinate along a great circle
     * path between the origin and the destination coordinates.
     */
    public function middle(): CoordinatesInterface
    {
        $latA = deg2rad($this->from->getLatitude());
        $lngA = deg2rad($this->from->getLongitude());
        $latB = deg2rad($this->to->getLatitude());
        $lngB = deg2rad($this->to->getLongitude());

        $bx = cos($latB) * cos($lngB - $lngA);
        $by = cos($latB) * sin($lngB - $lngA);

        $lat3 = rad2deg(atan2(sin($latA) + sin($latB), sqrt((cos($latA) + $bx) * (cos($latA) + $bx) + $by * $by)));
        $lng3 = rad2deg($lngA + atan2($by, cos($latA) + $bx));

        return new Coordinates($lat3, $lng3);
    }

    /**
     * Returns the destination point with a given bearing in degrees travelling along a
     * (shortest distance) great circle arc and a distance in meters.
     */
    public function destination(int $bearing, int $distance): Coordinates
    {
        $lat = deg2rad($this->from->getLatitude());
        $lng = deg2rad($this->from->getLongitude());

        $bearing = deg2rad($bearing);

        $endLat = asin(sin($lat) * cos($distance / $this->from->getEllipsoid()->getA()) + cos($lat) *
            sin($distance / $this->from->getEllipsoid()->getA()) * cos($bearing));
        $endLon = $lng + atan2(sin($bearing) * sin($distance / $this->from->getEllipsoid()->getA()) * cos($lat),
            cos($distance / $this->from->getEllipsoid()->getA()) - sin($lat) * sin($endLat));

        return new Coordinates(rad2deg($endLat), rad2deg($endLon));
    }

    /**
     * Returns true if the vertex passed on argument is on the same line as this object
     */
    public function isOnSameLine(Vertex $vertex): bool
    {
        if (is_null($this->getGradient()) && is_null($vertex->getGradient()) && $this->from->getLongitude() === $vertex->getFrom()->getLongitude()) {
            return true;
        }

        if (!is_null($this->getGradient()) && !is_null($vertex->getGradient())) {
            return bccomp(
                number_format($this->getGradient(), $this->getPrecision()),
                number_format($vertex->getGradient(), $this->getPrecision()),
                $this->getPrecision(),
            ) === 0
                && bccomp(
                    number_format($this->getOrdinateIntercept(), $this->getPrecision()),
                    number_format($vertex->getOrdinateIntercept(), $this->getPrecision()),
                    $this->getPrecision(),
                ) === 0;
        }

        return false;
    }

    /**
     * Returns the other coordinate who is not the coordinate passed on argument
     */
    public function getOtherCoordinate(CoordinatesInterface $coordinate): ?CoordinatesInterface
    {
        if ($coordinate->isEqual($this->from)) {
            return $this->to;
        }

        if ($coordinate->isEqual($this->to)) {
            return $this->from;
        }

        return null;
    }

    /**
     * Returns the determinant value between $this (vertex) and another vertex.
     */
    public function getDeterminant(Vertex $vertex): string
    {
        $abscissaVertexOne = $this->to->getLatitude() - $this->from->getLatitude();
        $ordinateVertexOne = $this->to->getLongitude() - $this->from->getLongitude();
        $abscissaVertexSecond = $vertex->getTo()->getLatitude() - $vertex->getFrom()->getLatitude();
        $ordinateVertexSecond = $vertex->getTo()->getLongitude() - $vertex->getFrom()->getLongitude();

        return bcsub(
            bcmul(
                number_format($abscissaVertexOne, $this->getPrecision()),
                number_format($ordinateVertexSecond, $this->getPrecision()),
                $this->getPrecision(),
            ),
            bcmul(
                number_format($abscissaVertexSecond, $this->getPrecision()),
                number_format($ordinateVertexOne, $this->getPrecision()),
                $this->getPrecision(),
            ),
            $this->getPrecision(),
        );
    }
}
