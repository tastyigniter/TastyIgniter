<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Override;

class Coordinates implements CoordinatesInterface
{
    public function __construct(
        private null|int|float $latitude,
        private null|int|float $longitude,
        private ?Ellipsoid $ellipsoid = null,
        private ?int $precision = null,
    ) {
        $this->latitude = $this->normalizeLatitude($latitude);
        $this->longitude = $this->normalizeLongitude($longitude);
        $this->ellipsoid = $ellipsoid ?: Ellipsoid::createFromName(Ellipsoid::WGS84);
        $this->precision = $precision ?? config('igniter-geocoder.precision', 8);
    }

    /**
     * Set the latitude.
     */
    #[Override]
    public function setLatitude(int|float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Set the longitude.
     */
    #[Override]
    public function setLongitude(int|float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function setPrecision(int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Returns the latitude.
     */
    #[Override]
    public function getLatitude(): int|float
    {
        return $this->latitude;
    }

    /**
     * Returns the longitude.
     */
    #[Override]
    public function getLongitude(): int|float
    {
        return $this->longitude;
    }

    #[Override]
    public function getEllipsoid(): Ellipsoid
    {
        return $this->ellipsoid;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }

    /**
     * Returns a boolean determining coordinates equality
     */
    #[Override]
    public function isEqual(CoordinatesInterface $coordinate): bool
    {
        return bccomp(
            number_format($this->latitude, $this->getPrecision()),
            number_format($coordinate->getLatitude(), $this->getPrecision()),
            $this->getPrecision(),
        ) === 0
            && bccomp(
                number_format($this->longitude, $this->getPrecision()),
                number_format($coordinate->getLongitude(), $this->getPrecision()),
                $this->getPrecision(),
            ) === 0;
    }

    /**
     * Normalizes a latitude to the (-90, 90) range.
     * Latitudes below -90.0 or above 90.0 degrees are capped, not wrapped.
     */
    #[Override]
    public function normalizeLatitude(int|float $latitude): int|float
    {
        return (float)max(-90, min(90, $latitude));
    }

    /**
     * Normalizes a longitude to the (-180, 180) range.
     * Longitudes below -180.0 or abode 180.0 degrees are wrapped.
     */
    #[Override]
    public function normalizeLongitude(int|float $longitude): int|float
    {
        if ($longitude % 360 === 180) {
            return 180.0;
        }

        $mod = fmod($longitude, 360);
        $fallback = $mod > 180 ? $mod - 360 : $mod;

        return $mod < -180 ? $mod + 360 : $fallback;
    }

    /**
     * Returns the coordinates as a tuple
     */
    #[Override]
    public function toArray(): array
    {
        return [$this->getLatitude(), $this->getLongitude()];
    }
}
