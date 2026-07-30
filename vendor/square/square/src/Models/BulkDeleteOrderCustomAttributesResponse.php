<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a response from deleting one or more order custom attributes.
 */
class BulkDeleteOrderCustomAttributesResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var array<string,DeleteOrderCustomAttributeResponse>
     */
    private $values;

    /**
     * @param array<string,DeleteOrderCustomAttributeResponse> $values
     */
    public function __construct(array $values)
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
     * Returns Values.
     * A map of responses that correspond to individual delete requests. Each response has the same ID
     * as the corresponding request and contains either a `custom_attribute` or an `errors` field.
     *
     * @return array<string,DeleteOrderCustomAttributeResponse>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Sets Values.
     * A map of responses that correspond to individual delete requests. Each response has the same ID
     * as the corresponding request and contains either a `custom_attribute` or an `errors` field.
     *
     * @required
     * @maps values
     *
     * @param array<string,DeleteOrderCustomAttributeResponse> $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
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
            $json['errors'] = $this->errors;
        }
        $json['values']     = $this->values;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
