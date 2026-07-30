<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response to a request to get an `EmployeeWage`. The response contains
 * the requested `EmployeeWage` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class GetEmployeeWageResponse implements \JsonSerializable
{
    /**
     * @var EmployeeWage|null
     */
    private $employeeWage;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Employee Wage.
     * The hourly wage rate that an employee earns on a `Shift` for doing the job
     * specified by the `title` property of this object. Deprecated at version 2020-08-26. Use
     * `TeamMemberWage` instead.
     */
    public function getEmployeeWage(): ?EmployeeWage
    {
        return $this->employeeWage;
    }

    /**
     * Sets Employee Wage.
     * The hourly wage rate that an employee earns on a `Shift` for doing the job
     * specified by the `title` property of this object. Deprecated at version 2020-08-26. Use
     * `TeamMemberWage` instead.
     *
     * @maps employee_wage
     */
    public function setEmployeeWage(?EmployeeWage $employeeWage): void
    {
        $this->employeeWage = $employeeWage;
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
        if (isset($this->employeeWage)) {
            $json['employee_wage'] = $this->employeeWage;
        }
        if (isset($this->errors)) {
            $json['errors']        = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
