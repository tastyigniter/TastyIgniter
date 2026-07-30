<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an update request for a `TeamMember` object.
 */
class UpdateTeamMemberRequest implements \JsonSerializable
{
    /**
     * @var TeamMember|null
     */
    private $teamMember;

    /**
     * Returns Team Member.
     * A record representing an individual team member for a business.
     */
    public function getTeamMember(): ?TeamMember
    {
        return $this->teamMember;
    }

    /**
     * Sets Team Member.
     * A record representing an individual team member for a business.
     *
     * @maps team_member
     */
    public function setTeamMember(?TeamMember $teamMember): void
    {
        $this->teamMember = $teamMember;
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
        if (isset($this->teamMember)) {
            $json['team_member'] = $this->teamMember;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
