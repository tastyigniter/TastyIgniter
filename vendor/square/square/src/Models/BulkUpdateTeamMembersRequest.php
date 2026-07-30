<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a bulk update request for `TeamMember` objects.
 */
class BulkUpdateTeamMembersRequest implements \JsonSerializable
{
    /**
     * @var array<string,UpdateTeamMemberRequest>
     */
    private $teamMembers;

    /**
     * @param array<string,UpdateTeamMemberRequest> $teamMembers
     */
    public function __construct(array $teamMembers)
    {
        $this->teamMembers = $teamMembers;
    }

    /**
     * Returns Team Members.
     * The data used to update the `TeamMember` objects. Each key is the `team_member_id` that maps to the
     * `UpdateTeamMemberRequest`. The maximum number of update objects is 25.
     *
     * @return array<string,UpdateTeamMemberRequest>
     */
    public function getTeamMembers(): array
    {
        return $this->teamMembers;
    }

    /**
     * Sets Team Members.
     * The data used to update the `TeamMember` objects. Each key is the `team_member_id` that maps to the
     * `UpdateTeamMemberRequest`. The maximum number of update objects is 25.
     *
     * @required
     * @maps team_members
     *
     * @param array<string,UpdateTeamMemberRequest> $teamMembers
     */
    public function setTeamMembers(array $teamMembers): void
    {
        $this->teamMembers = $teamMembers;
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
        $json['team_members'] = $this->teamMembers;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
