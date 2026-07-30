<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response to a request to get a `Shift`. The response contains
 * the requested `Shift` object and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class GetShiftResponse implements \JsonSerializable
{
    /**
     * @var Shift|null
     */
    private $shift;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Shift.
     * A record of the hourly rate, start, and end times for a single work shift
     * for an employee. This might include a record of the start and end times for breaks
     * taken during the shift.
     */
    public function getShift(): ?Shift
    {
        return $this->shift;
    }

    /**
     * Sets Shift.
     * A record of the hourly rate, start, and end times for a single work shift
     * for an employee. This might include a record of the start and end times for breaks
     * taken during the shift.
     *
     * @maps shift
     */
    public function setShift(?Shift $shift): void
    {
        $this->shift = $shift;
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
        if (isset($this->shift)) {
            $json['shift']  = $this->shift;
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
