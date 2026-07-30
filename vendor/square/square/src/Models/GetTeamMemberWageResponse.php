<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response to a request to get a `TeamMemberWage`. The response contains
 * the requested `TeamMemberWage` objects and might contain a set of `Error` objects if
 * the request resulted in errors.
 */
class GetTeamMemberWageResponse implements \JsonSerializable
{
    /**
     * @var TeamMemberWage|null
     */
    private $teamMemberWage;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Member Wage.
     * The hourly wage rate that a team member earns on a `Shift` for doing the job
     * specified by the `title` property of this object.
     */
    public function getTeamMemberWage(): ?TeamMemberWage
    {
        return $this->teamMemberWage;
    }

    /**
     * Sets Team Member Wage.
     * The hourly wage rate that a team member earns on a `Shift` for doing the job
     * specified by the `title` property of this object.
     *
     * @maps team_member_wage
     */
    public function setTeamMemberWage(?TeamMemberWage $teamMemberWage): void
    {
        $this->teamMemberWage = $teamMemberWage;
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
        if (isset($this->teamMemberWage)) {
            $json['team_member_wage'] = $this->teamMemberWage;
        }
        if (isset($this->errors)) {
            $json['errors']           = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
