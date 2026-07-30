<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response to a request for `Shift` objects. The response contains
 * the requested `Shift` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class SearchShiftsResponse implements \JsonSerializable
{
    /**
     * @var Shift[]|null
     */
    private $shifts;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Shifts.
     * Shifts.
     *
     * @return Shift[]|null
     */
    public function getShifts(): ?array
    {
        return $this->shifts;
    }

    /**
     * Sets Shifts.
     * Shifts.
     *
     * @maps shifts
     *
     * @param Shift[]|null $shifts
     */
    public function setShifts(?array $shifts): void
    {
        $this->shifts = $shifts;
    }

    /**
     * Returns Cursor.
     * An opaque cursor for fetching the next page.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * An opaque cursor for fetching the next page.
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
        if (isset($this->shifts)) {
            $json['shifts'] = $this->shifts;
        }
        if (isset($this->cursor)) {
            $json['cursor'] = $this->cursor;
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
