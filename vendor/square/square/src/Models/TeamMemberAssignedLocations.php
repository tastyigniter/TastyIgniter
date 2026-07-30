<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An object that represents a team member's assignment to locations.
 */
class TeamMemberAssignedLocations implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $assignmentType;

    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * Returns Assignment Type.
     * Enumerates the possible assignment types that the team member can have.
     */
    public function getAssignmentType(): ?string
    {
        return $this->assignmentType;
    }

    /**
     * Sets Assignment Type.
     * Enumerates the possible assignment types that the team member can have.
     *
     * @maps assignment_type
     */
    public function setAssignmentType(?string $assignmentType): void
    {
        $this->assignmentType = $assignmentType;
    }

    /**
     * Returns Location Ids.
     * The explicit locations that the team member is assigned to.
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
     * The explicit locations that the team member is assigned to.
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
     * The explicit locations that the team member is assigned to.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
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
        if (isset($this->assignmentType)) {
            $json['assignment_type'] = $this->assignmentType;
        }
        if (!empty($this->locationIds)) {
            $json['location_ids']    = $this->locationIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
