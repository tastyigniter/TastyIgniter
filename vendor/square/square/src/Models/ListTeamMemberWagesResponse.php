<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The response to a request for a set of `TeamMemberWage` objects. The response contains
 * a set of `TeamMemberWage` objects.
 */
class ListTeamMemberWagesResponse implements \JsonSerializable
{
    /**
     * @var TeamMemberWage[]|null
     */
    private $teamMemberWages;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Member Wages.
     * A page of `TeamMemberWage` results.
     *
     * @return TeamMemberWage[]|null
     */
    public function getTeamMemberWages(): ?array
    {
        return $this->teamMemberWages;
    }

    /**
     * Sets Team Member Wages.
     * A page of `TeamMemberWage` results.
     *
     * @maps team_member_wages
     *
     * @param TeamMemberWage[]|null $teamMemberWages
     */
    public function setTeamMemberWages(?array $teamMemberWages): void
    {
        $this->teamMemberWages = $teamMemberWages;
    }

    /**
     * Returns Cursor.
     * The value supplied in the subsequent request to fetch the next page
     * of `TeamMemberWage` results.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The value supplied in the subsequent request to fetch the next page
     * of `TeamMemberWage` results.
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
        if (isset($this->teamMemberWages)) {
            $json['team_member_wages'] = $this->teamMemberWages;
        }
        if (isset($this->cursor)) {
            $json['cursor']            = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']            = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
