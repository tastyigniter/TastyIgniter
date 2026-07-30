<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RetrieveEmployeeResponse implements \JsonSerializable
{
    /**
     * @var Employee|null
     */
    private $employee;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Employee.
     * An employee object that is used by the external API.
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * Sets Employee.
     * An employee object that is used by the external API.
     *
     * @maps employee
     */
    public function setEmployee(?Employee $employee): void
    {
        $this->employee = $employee;
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
        if (isset($this->employee)) {
            $json['employee'] = $this->employee;
        }
        if (isset($this->errors)) {
            $json['errors']   = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
