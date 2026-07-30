<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response to a request to update a `BreakType`. The response contains
 * the requested `BreakType` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class UpdateBreakTypeResponse implements \JsonSerializable
{
    /**
     * @var BreakType|null
     */
    private $breakType;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Break Type.
     * A defined break template that sets an expectation for possible `Break`
     * instances on a `Shift`.
     */
    public function getBreakType(): ?BreakType
    {
        return $this->breakType;
    }

    /**
     * Sets Break Type.
     * A defined break template that sets an expectation for possible `Break`
     * instances on a `Shift`.
     *
     * @maps break_type
     */
    public function setBreakType(?BreakType $breakType): void
    {
        $this->breakType = $breakType;
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
        if (isset($this->breakType)) {
            $json['break_type'] = $this->breakType;
        }
        if (isset($this->errors)) {
            $json['errors']     = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
