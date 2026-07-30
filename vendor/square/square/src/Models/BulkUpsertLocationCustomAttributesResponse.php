<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a
 * [BulkUpsertLocationCustomAttributes]($e/LocationCustomAttributes/BulkUpsertLocationCustomAttributes)
 * response,
 * which contains a map of responses that each corresponds to an individual upsert request.
 */
class BulkUpsertLocationCustomAttributesResponse implements \JsonSerializable
{
    /**
     * @var array<string,BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse>|null
     */
    private $values;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Values.
     * A map of responses that correspond to individual upsert requests. Each response has the
     * same ID as the corresponding request and contains either a `location_id` and `custom_attribute` or
     * an `errors` field.
     *
     * @return array<string,BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse>|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * Sets Values.
     * A map of responses that correspond to individual upsert requests. Each response has the
     * same ID as the corresponding request and contains either a `location_id` and `custom_attribute` or
     * an `errors` field.
     *
     * @maps values
     *
     * @param array<string,BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse>|null $values
     */
    public function setValues(?array $values): void
    {
        $this->values = $values;
    }

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
        if (isset($this->values)) {
            $json['values'] = $this->values;
        }
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
