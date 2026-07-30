<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ListTeamMemberBookingProfilesResponse implements \JsonSerializable
{
    /**
     * @var TeamMemberBookingProfile[]|null
     */
    private $teamMemberBookingProfiles;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Team Member Booking Profiles.
     * The list of team member booking profiles. The results are returned in the ascending order of the
     * time
     * when the team member booking profiles were last updated. Multiple booking profiles updated at the
     * same time
     * are further sorted in the ascending order of their IDs.
     *
     * @return TeamMemberBookingProfile[]|null
     */
    public function getTeamMemberBookingProfiles(): ?array
    {
        return $this->teamMemberBookingProfiles;
    }

    /**
     * Sets Team Member Booking Profiles.
     * The list of team member booking profiles. The results are returned in the ascending order of the
     * time
     * when the team member booking profiles were last updated. Multiple booking profiles updated at the
     * same time
     * are further sorted in the ascending order of their IDs.
     *
     * @maps team_member_booking_profiles
     *
     * @param TeamMemberBookingProfile[]|null $teamMemberBookingProfiles
     */
    public function setTeamMemberBookingProfiles(?array $teamMemberBookingProfiles): void
    {
        $this->teamMemberBookingProfiles = $teamMemberBookingProfiles;
    }

    /**
     * Returns Cursor.
     * The pagination cursor to be used in the subsequent request to get the next page of the results. Stop
     * retrieving the next page of the results when the cursor is not set.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     * The pagination cursor to be used in the subsequent request to get the next page of the results. Stop
     * retrieving the next page of the results when the cursor is not set.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Errors.
     * Errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Errors that occurred during the request.
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
        if (isset($this->teamMemberBookingProfiles)) {
            $json['team_member_booking_profiles'] = $this->teamMemberBookingProfiles;
        }
        if (isset($this->cursor)) {
            $json['cursor']                       = $this->cursor;
        }
        if (isset($this->errors)) {
            $json['errors']                       = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
