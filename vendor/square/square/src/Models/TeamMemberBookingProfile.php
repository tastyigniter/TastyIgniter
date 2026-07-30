<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The booking profile of a seller's team member, including the team member's ID, display name,
 * description and whether the team member can be booked as a service provider.
 */
class TeamMemberBookingProfile implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $teamMemberId;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $displayName;

    /**
     * @var array
     */
    private $isBookable = [];

    /**
     * @var string|null
     */
    private $profileImageUrl;

    /**
     * Returns Team Member Id.
     * The ID of the [TeamMember](entity:TeamMember) object for the team member associated with the booking
     * profile.
     */
    public function getTeamMemberId(): ?string
    {
        return $this->teamMemberId;
    }

    /**
     * Sets Team Member Id.
     * The ID of the [TeamMember](entity:TeamMember) object for the team member associated with the booking
     * profile.
     *
     * @maps team_member_id
     */
    public function setTeamMemberId(?string $teamMemberId): void
    {
        $this->teamMemberId = $teamMemberId;
    }

    /**
     * Returns Description.
     * The description of the team member.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     * The description of the team member.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Display Name.
     * The display name of the team member.
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Sets Display Name.
     * The display name of the team member.
     *
     * @maps display_name
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * Returns Is Bookable.
     * Indicates whether the team member can be booked through the Bookings API or the seller's online
     * booking channel or site (`true) or not (`false`).
     */
    public function getIsBookable(): ?bool
    {
        if (count($this->isBookable) == 0) {
            return null;
        }
        return $this->isBookable['value'];
    }

    /**
     * Sets Is Bookable.
     * Indicates whether the team member can be booked through the Bookings API or the seller's online
     * booking channel or site (`true) or not (`false`).
     *
     * @maps is_bookable
     */
    public function setIsBookable(?bool $isBookable): void
    {
        $this->isBookable['value'] = $isBookable;
    }

    /**
     * Unsets Is Bookable.
     * Indicates whether the team member can be booked through the Bookings API or the seller's online
     * booking channel or site (`true) or not (`false`).
     */
    public function unsetIsBookable(): void
    {
        $this->isBookable = [];
    }

    /**
     * Returns Profile Image Url.
     * The URL of the team member's image for the bookings profile.
     */
    public function getProfileImageUrl(): ?string
    {
        return $this->profileImageUrl;
    }

    /**
     * Sets Profile Image Url.
     * The URL of the team member's image for the bookings profile.
     *
     * @maps profile_image_url
     */
    public function setProfileImageUrl(?string $profileImageUrl): void
    {
        $this->profileImageUrl = $profileImageUrl;
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
        if (isset($this->teamMemberId)) {
            $json['team_member_id']    = $this->teamMemberId;
        }
        if (isset($this->description)) {
            $json['description']       = $this->description;
        }
        if (isset($this->displayName)) {
            $json['display_name']      = $this->displayName;
        }
        if (!empty($this->isBookable)) {
            $json['is_bookable']       = $this->isBookable['value'];
        }
        if (isset($this->profileImageUrl)) {
            $json['profile_image_url'] = $this->profileImageUrl;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
