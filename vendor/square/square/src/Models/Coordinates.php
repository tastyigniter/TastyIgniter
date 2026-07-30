<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Latitude and longitude coordinates.
 */
class Coordinates implements \JsonSerializable
{
    /**
     * @var array
     */
    private $latitude = [];

    /**
     * @var array
     */
    private $longitude = [];

    /**
     * Returns Latitude.
     * The latitude of the coordinate expressed in degrees.
     */
    public function getLatitude(): ?float
    {
        if (count($this->latitude) == 0) {
            return null;
        }
        return $this->latitude['value'];
    }

    /**
     * Sets Latitude.
     * The latitude of the coordinate expressed in degrees.
     *
     * @maps latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude['value'] = $latitude;
    }

    /**
     * Unsets Latitude.
     * The latitude of the coordinate expressed in degrees.
     */
    public function unsetLatitude(): void
    {
        $this->latitude = [];
    }

    /**
     * Returns Longitude.
     * The longitude of the coordinate expressed in degrees.
     */
    public function getLongitude(): ?float
    {
        if (count($this->longitude) == 0) {
            return null;
        }
        return $this->longitude['value'];
    }

    /**
     * Sets Longitude.
     * The longitude of the coordinate expressed in degrees.
     *
     * @maps longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude['value'] = $longitude;
    }

    /**
     * Unsets Longitude.
     * The longitude of the coordinate expressed in degrees.
     */
    public function unsetLongitude(): void
    {
        $this->longitude = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->latitude)) {
            $json['latitude']  = $this->latitude['value'];
        }
        if (!empty($this->longitude)) {
            $json['longitude'] = $this->longitude['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
