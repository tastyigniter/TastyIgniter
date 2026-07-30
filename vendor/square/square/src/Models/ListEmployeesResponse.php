<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListEmployeesResponse implements \JsonSerializable
{
    /**
     * @var Employee[]|null
     */
    private $employees;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Employees.
     *
     * @return Employee[]|null
     */
    public function getEmployees(): ?array
    {
        return $this->employees;
    }

    /**
     * Sets Employees.
     *
     * @maps employees
     *
     * @param Employee[]|null $employees
     */
    public function setEmployees(?array $employees): void
    {
        $this->employees = $employees;
    }

    /**
     * Returns Cursor.
     * The token to be used to retrieve the next page of results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The token to be used to retrieve the next page of results.
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
        if (isset($this->employees)) {
            $json['employees'] = $this->employees;
        }
        if (isset($this->cursor)) {
            $json['cursor']    = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']    = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
