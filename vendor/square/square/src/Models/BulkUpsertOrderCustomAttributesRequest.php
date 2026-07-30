<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a bulk upsert request for one or more order custom attributes.
 */
class BulkUpsertOrderCustomAttributesRequest implements \JsonSerializable
{
    /**
     * @var array<string,BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute>
     */
    private $values;

    /**
     * @param array<string,BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute> $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Returns Values.
     * A map of requests that correspond to individual upsert operations for custom attributes.
     *
     * @return array<string,BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Sets Values.
     * A map of requests that correspond to individual upsert operations for custom attributes.
     *
     * @required
     * @maps values
     *
     * @param array<string,BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute> $values
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
        $json['values'] = $this->values;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
