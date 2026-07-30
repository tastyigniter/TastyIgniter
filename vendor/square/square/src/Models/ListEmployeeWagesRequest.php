<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request for a set of `EmployeeWage` objects.
 */
class ListEmployeeWagesRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $employeeId = [];

    /**
     * @var array
     */
    private $limit = [];

    /**
     * @var array
     */
    private $cursor = [];

    /**
     * Returns Employee Id.
     * Filter the returned wages to only those that are associated with the specified employee.
     */
    public function getEmployeeId(): ?string
    {
        if (count($this->employeeId) == 0) {
            return null;
        }
        return $this->employeeId['value'];
    }

    /**
     * Sets Employee Id.
     * Filter the returned wages to only those that are associated with the specified employee.
     *
     * @maps employee_id
     */
    public function setEmployeeId(?string $employeeId): void
    {
        $this->employeeId['value'] = $employeeId;
    }

    /**
     * Unsets Employee Id.
     * Filter the returned wages to only those that are associated with the specified employee.
     */
    public function unsetEmployeeId(): void
    {
        $this->employeeId = [];
    }

    /**
     * Returns Limit.
     * The maximum number of `EmployeeWage` results to return per page. The number can range between
     * 1 and 200. The default is 200.
     */
    public function getLimit(): ?int
    {
        if (count($this->limit) == 0) {
            return null;
        }
        return $this->limit['value'];
    }

    /**
     * Sets Limit.
     * The maximum number of `EmployeeWage` results to return per page. The number can range between
     * 1 and 200. The default is 200.
     *
     * @maps limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit['value'] = $limit;
    }

    /**
     * Unsets Limit.
     * The maximum number of `EmployeeWage` results to return per page. The number can range between
     * 1 and 200. The default is 200.
     */
    public function unsetLimit(): void
    {
        $this->limit = [];
    }

    /**
     * Returns Cursor.
     * A pointer to the next page of `EmployeeWage` results to fetch.
     */
    public function getCursor(): ?string
    {
        if (count($this->cursor) == 0) {
            return null;
        }
        return $this->cursor['value'];
    }

    /**
     * Sets Cursor.
     * A pointer to the next page of `EmployeeWage` results to fetch.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor['value'] = $cursor;
    }

    /**
     * Unsets Cursor.
     * A pointer to the next page of `EmployeeWage` results to fetch.
     */
    public function unsetCursor(): void
    {
        $this->cursor = [];
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
        if (!empty($this->employeeId)) {
            $json['employee_id'] = $this->employeeId['value'];
        }
        if (!empty($this->limit)) {
            $json['limit']       = $this->limit['value'];
        }
        if (!empty($this->cursor)) {
            $json['cursor']      = $this->cursor['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
