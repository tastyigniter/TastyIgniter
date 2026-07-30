<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response to a request for a set of `BreakType` objects. The response contains
 * the requested `BreakType` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class ListBreakTypesResponse implements \JsonSerializable
{
    /**
     * @var BreakType[]|null
     */
    private $breakTypes;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Break Types.
     * A page of `BreakType` results.
     *
     * @return BreakType[]|null
     */
    public function getBreakTypes(): ?array
    {
        return $this->breakTypes;
    }

    /**
     * Sets Break Types.
     * A page of `BreakType` results.
     *
     * @maps break_types
     *
     * @param BreakType[]|null $breakTypes
     */
    public function setBreakTypes(?array $breakTypes): void
    {
        $this->breakTypes = $breakTypes;
    }

    /**
     * Returns Cursor.
     * The value supplied in the subsequent request to fetch the next page
     * of `BreakType` results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The value supplied in the subsequent request to fetch the next page
     * of `BreakType` results.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
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
        if (isset($this->breakTypes)) {
            $json['break_types'] = $this->breakTypes;
        }
        if (isset($this->cursor)) {
            $json['cursor']      = $this->cursor;
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
