<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class SearchAvailabilityResponse implements \JsonSerializable
{
    /**
     * @var Availability[]|null
     */
    private $availabilities;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Availabilities.
     * List of appointment slots available for booking.
     *
     * @return Availability[]|null
     */
    public function getAvailabilities(): ?array
    {
        return $this->availabilities;
    }

    /**
     * Sets Availabilities.
     * List of appointment slots available for booking.
     *
     * @maps availabilities
     *
     * @param Availability[]|null $availabilities
     */
    public function setAvailabilities(?array $availabilities): void
    {
        $this->availabilities = $availabilities;
    }

    /**
     * Returns Errors.
     * Errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors that occurred during the request.
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
        if (isset($this->availabilities)) {
            $json['availabilities'] = $this->availabilities;
        }
        if (isset($this->errors)) {
            $json['errors']         = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
