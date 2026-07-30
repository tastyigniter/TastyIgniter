<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

use Igniter\Flame\Geolite\Model\Ellipsoid;

interface CoordinatesInterface
{
    /**
     * Normalizes a latitude to the (-90, 90) range.
     * Latitudes below -90.0 or above 90.0 degrees are capped, not wrapped.
     */
    public function normalizeLatitude(int|float $latitude): int|float;

    /**
     * Normalizes a longitude to the (-180, 180) range.
     * Longitudes below -180.0 or abode 180.0 degrees are wrapped.
     */
    public function normalizeLongitude(int|float $longitude): int|float;

    /**
     * Set the latitude.
     */
    public function setLatitude(float $latitude): self;

    /**
     * Get the latitude.
     */
    public function getLatitude(): int|float;

    /**
     * Set the longitude.
     */
    public function setLongitude(float $longitude): self;

    /**
     * Get the longitude.
     */
    public function getLongitude(): int|float;

    /**
     * Get the Ellipsoid.
     */
    public function getEllipsoid(): Ellipsoid;

    /**
     * Returns a boolean determining coordinates equality
     */
    public function isEqual(CoordinatesInterface $coordinate): bool;

    public function toArray(): array;
}
