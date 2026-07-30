<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of a request
 * to the [ListLocations]($e/Locations/ListLocations) endpoint.
 *
 * Either `errors` or `locations` is present in a given response (never both).
 */
class ListLocationsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var Location[]|null
     */
    private $locations;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Locations.
     * The business locations.
     *
     * @return Location[]|null
     */
    public function getLocations(): ?array
    {
        return $this->locations;
    }

    /**
     * Sets Locations.
     * The business locations.
     *
     * @maps locations
     *
     * @param Location[]|null $locations
     */
    public function setLocations(?array $locations): void
    {
        $this->locations = $locations;
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
        if (isset($this->errors)) {
            $json['errors']    = $this->errors;
        }
        if (isset($this->locations)) {
            $json['locations'] = $this->locations;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
