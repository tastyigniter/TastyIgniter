<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines a filter used in a search for `Shift` records. `AND` logic is
 * used by Square's servers to apply each filter property specified.
 */
class ShiftFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var array
     */
    private $employeeIds = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var TimeRange|null
     */
    private $start;

    /**
     * @var TimeRange|null
     */
    private $end;

    /**
     * @var ShiftWorkday|null
     */
    private $workday;

    /**
     * @var array
     */
    private $teamMemberIds = [];

    /**
     * Returns Location Ids.
     * Fetch shifts for the specified location.
     *
     * @return string[]|null
     */
    public function getLocationIds(): ?array
    {
        if (count($this->locationIds) == 0) {
            return null;
        }
        return $this->locationIds['value'];
    }

    /**
     * Sets Location Ids.
     * Fetch shifts for the specified location.
     *
     * @maps location_ids
     *
     * @param string[]|null $locationIds
     */
    public function setLocationIds(?array $locationIds): void
    {
        $this->locationIds['value'] = $locationIds;
    }

    /**
     * Unsets Location Ids.
     * Fetch shifts for the specified location.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Employee Ids.
     * Fetch shifts for the specified employees. DEPRECATED at version 2020-08-26. Use `team_member_ids`
     * instead.
     *
     * @return string[]|null
     */
    public function getEmployeeIds(): ?array
    {
        if (count($this->employeeIds) == 0) {
            return null;
        }
        return $this->employeeIds['value'];
    }

    /**
     * Sets Employee Ids.
     * Fetch shifts for the specified employees. DEPRECATED at version 2020-08-26. Use `team_member_ids`
     * instead.
     *
     * @maps employee_ids
     *
     * @param string[]|null $employeeIds
     */
    public function setEmployeeIds(?array $employeeIds): void
    {
        $this->employeeIds['value'] = $employeeIds;
    }

    /**
     * Unsets Employee Ids.
     * Fetch shifts for the specified employees. DEPRECATED at version 2020-08-26. Use `team_member_ids`
     * instead.
     */
    public function unsetEmployeeIds(): void
    {
        $this->employeeIds = [];
    }

    /**
     * Returns Status.
     * Specifies the `status` of `Shift` records to be returned.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Specifies the `status` of `Shift` records to be returned.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Start.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getStart(): ?TimeRange
    {
        return $this->start;
    }

    /**
     * Sets Start.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps start
     */
    public function setStart(?TimeRange $start): void
    {
        $this->start = $start;
    }

    /**
     * Returns End.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getEnd(): ?TimeRange
    {
        return $this->end;
    }

    /**
     * Sets End.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps end
     */
    public function setEnd(?TimeRange $end): void
    {
        $this->end = $end;
    }

    /**
     * Returns Workday.
     * A `Shift` search query filter parameter that sets a range of days that
     * a `Shift` must start or end in before passing the filter condition.
     */
    public function getWorkday(): ?ShiftWorkday
    {
        return $this->workday;
    }

    /**
     * Sets Workday.
     * A `Shift` search query filter parameter that sets a range of days that
     * a `Shift` must start or end in before passing the filter condition.
     *
     * @maps workday
     */
    public function setWorkday(?ShiftWorkday $workday): void
    {
        $this->workday = $workday;
    }

    /**
     * Returns Team Member Ids.
     * Fetch shifts for the specified team members. Replaced `employee_ids` at version "2020-08-26".
     *
     * @return string[]|null
     */
    public function getTeamMemberIds(): ?array
    {
        if (count($this->teamMemberIds) == 0) {
            return null;
        }
        return $this->teamMemberIds['value'];
    }

    /**
     * Sets Team Member Ids.
     * Fetch shifts for the specified team members. Replaced `employee_ids` at version "2020-08-26".
     *
     * @maps team_member_ids
     *
     * @param string[]|null $teamMemberIds
     */
    public function setTeamMemberIds(?array $teamMemberIds): void
    {
        $this->teamMemberIds['value'] = $teamMemberIds;
    }

    /**
     * Unsets Team Member Ids.
     * Fetch shifts for the specified team members. Replaced `employee_ids` at version "2020-08-26".
     */
    public function unsetTeamMemberIds(): void
    {
        $this->teamMemberIds = [];
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
        if (!empty($this->locationIds)) {
            $json['location_ids']    = $this->locationIds['value'];
        }
        if (!empty($this->employeeIds)) {
            $json['employee_ids']    = $this->employeeIds['value'];
        }
        if (isset($this->status)) {
            $json['status']          = $this->status;
        }
        if (isset($this->start)) {
            $json['start']           = $this->start;
        }
        if (isset($this->end)) {
            $json['end']             = $this->end;
        }
        if (isset($this->workday)) {
            $json['workday']         = $this->workday;
        }
        if (!empty($this->teamMemberIds)) {
            $json['team_member_ids'] = $this->teamMemberIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
