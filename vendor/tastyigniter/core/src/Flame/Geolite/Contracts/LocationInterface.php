<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Contracts;

use Igniter\Flame\Geolite\Model\AdminLevelCollection;
use Igniter\Flame\Geolite\Model\Bounds;
use Igniter\Flame\Geolite\Model\Coordinates;

interface LocationInterface
{
    /**
     * The name of the provider that created this Location.
     */
    public function getProvidedBy(): string;

    /**
     * Will always return the coordinates value object.
     */
    public function getCoordinates(): ?Coordinates;

    /**
     * Returns the bounds value object.
     */
    public function getBounds(): ?Bounds;

    /**
     * Returns the street number value.
     */
    public function getStreetNumber(): int|string|null;

    /**
     * Returns the street name value.
     */
    public function getStreetName(): ?string;

    /**
     * Returns the city or locality value.
     */
    public function getLocality(): ?string;

    /**
     * Returns the postal code or zipcode value.
     */
    public function getPostalCode(): null|int|string;

    /**
     * Returns the locality district, or sublocality, or neighborhood.
     */
    public function getSubLocality(): ?string;

    /**
     * Returns the administrative levels.
     */
    public function getAdminLevels(): AdminLevelCollection;

    /**
     * Returns the country name.
     */
    public function getCountryName(): ?string;

    /**
     * Returns the country code.
     */
    public function getCountryCode(): ?string;

    /**
     * Returns the timezone for the Location. The timezone MUST be in the list of supported timezones.
     *
     * {@link http://php.net/manual/en/timezones.php}
     */
    public function getTimezone(): ?string;

    /**
     * Returns an array with data indexed by name.
     */
    public function toArray(): array;
}
