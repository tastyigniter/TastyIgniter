<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an individual delete response in a
 * [BulkDeleteLocationCustomAttributes]($e/LocationCustomAttributes/BulkDeleteLocationCustomAttributes)
 * request.
 */
class BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Location Id.
     * The ID of the location associated with the custom attribute.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the location associated with the custom attribute.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Errors.
     * Errors that occurred while processing the individual LocationCustomAttributeDeleteRequest request
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors that occurred while processing the individual LocationCustomAttributeDeleteRequest request
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
        if (isset($this->locationId)) {
            $json['location_id'] = $this->locationId;
        }
        if (isset($this->errors)) {
            $json['errors']      = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
