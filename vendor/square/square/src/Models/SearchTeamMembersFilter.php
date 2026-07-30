<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a filter used in a search for `TeamMember` objects. `AND` logic is applied
 * between the individual fields, and `OR` logic is applied within list-based fields.
 * For example, setting this filter value:
 * ```
 * filter = (locations_ids = ["A", "B"], status = ACTIVE)
 * ```
 * returns only active team members assigned to either location "A" or "B".
 */
class SearchTeamMembersFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationIds = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var array
     */
    private $isOwner = [];

    /**
     * Returns Location Ids.
     * When present, filters by team members assigned to the specified locations.
     * When empty, includes team members assigned to any location.
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
     * When present, filters by team members assigned to the specified locations.
     * When empty, includes team members assigned to any location.
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
     * When present, filters by team members assigned to the specified locations.
     * When empty, includes team members assigned to any location.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Status.
     * Enumerates the possible statuses the team member can have within a business.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Enumerates the possible statuses the team member can have within a business.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Is Owner.
     * When present and set to true, returns the team member who is the owner of the Square account.
     */
    public function getIsOwner(): ?bool
    {
        if (count($this->isOwner) == 0) {
            return null;
        }
        return $this->isOwner['value'];
    }

    /**
     * Sets Is Owner.
     * When present and set to true, returns the team member who is the owner of the Square account.
     *
     * @maps is_owner
     */
    public function setIsOwner(?bool $isOwner): void
    {
        $this->isOwner['value'] = $isOwner;
    }

    /**
     * Unsets Is Owner.
     * When present and set to true, returns the team member who is the owner of the Square account.
     */
    public function unsetIsOwner(): void
    {
        $this->isOwner = [];
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
            $json['location_ids'] = $this->locationIds['value'];
        }
        if (isset($this->status)) {
            $json['status']       = $this->status;
        }
        if (!empty($this->isOwner)) {
            $json['is_owner']     = $this->isOwner['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
