<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Information about a booking creator.
 */
class BookingCreatorDetails implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $creatorType;

    /**
     * @var string|null
     */
    private $teamMemberId;

    /**
     * @var string|null
     */
    private $customerId;

    /**
     * Returns Creator Type.
     * Supported types of a booking creator.
     */
    public function getCreatorType(): ?string
    {
        return $this->creatorType;
    }

    /**
     * Sets Creator Type.
     * Supported types of a booking creator.
     *
     * @maps creator_type
     */
    public function setCreatorType(?string $creatorType): void
    {
        $this->creatorType = $creatorType;
    }

    /**
     * Returns Team Member Id.
     * The ID of the team member who created the booking, when the booking creator is of the `TEAM_MEMBER`
     * type.
     * Access to this field requires seller-level permissions.
     */
    public function getTeamMemberId(): ?string
    {
        return $this->teamMemberId;
    }

    /**
     * Sets Team Member Id.
     * The ID of the team member who created the booking, when the booking creator is of the `TEAM_MEMBER`
     * type.
     * Access to this field requires seller-level permissions.
     *
     * @maps team_member_id
     */
    public function setTeamMemberId(?string $teamMemberId): void
    {
        $this->teamMemberId = $teamMemberId;
    }

    /**
     * Returns Customer Id.
     * The ID of the customer who created the booking, when the booking creator is of the `CUSTOMER` type.
     * Access to this field requires seller-level permissions.
     */
    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    /**
     * Sets Customer Id.
     * The ID of the customer who created the booking, when the booking creator is of the `CUSTOMER` type.
     * Access to this field requires seller-level permissions.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId = $customerId;
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
        if (isset($this->creatorType)) {
            $json['creator_type']   = $this->creatorType;
        }
        if (isset($this->teamMemberId)) {
            $json['team_member_id'] = $this->teamMemberId;
        }
        if (isset($this->customerId)) {
            $json['customer_id']    = $this->customerId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
