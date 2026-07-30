<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A record representing an individual team member for a business.
 */
class TeamMember implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var bool|null
     */
    private $isOwner;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var array
     */
    private $givenName = [];

    /**
     * @var array
     */
    private $familyName = [];

    /**
     * @var array
     */
    private $emailAddress = [];

    /**
     * @var array
     */
    private $phoneNumber = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var TeamMemberAssignedLocations|null
     */
    private $assignedLocations;

    /**
     * Returns Id.
     * The unique ID for the team member.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The unique ID for the team member.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Reference Id.
     * A second ID used to associate the team member with an entity in another system.
     */
    public function getReferenceId(): ?string
    {
        if (count($this->referenceId) == 0) {
            return null;
        }
        return $this->referenceId['value'];
    }

    /**
     * Sets Reference Id.
     * A second ID used to associate the team member with an entity in another system.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId['value'] = $referenceId;
    }

    /**
     * Unsets Reference Id.
     * A second ID used to associate the team member with an entity in another system.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Is Owner.
     * Whether the team member is the owner of the Square account.
     */
    public function getIsOwner(): ?bool
    {
        return $this->isOwner;
    }

    /**
     * Sets Is Owner.
     * Whether the team member is the owner of the Square account.
     *
     * @maps is_owner
     */
    public function setIsOwner(?bool $isOwner): void
    {
        $this->isOwner = $isOwner;
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
     * Returns Given Name.
     * The given name (that is, the first name) associated with the team member.
     */
    public function getGivenName(): ?string
    {
        if (count($this->givenName) == 0) {
            return null;
        }
        return $this->givenName['value'];
    }

    /**
     * Sets Given Name.
     * The given name (that is, the first name) associated with the team member.
     *
     * @maps given_name
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName['value'] = $givenName;
    }

    /**
     * Unsets Given Name.
     * The given name (that is, the first name) associated with the team member.
     */
    public function unsetGivenName(): void
    {
        $this->givenName = [];
    }

    /**
     * Returns Family Name.
     * The family name (that is, the last name) associated with the team member.
     */
    public function getFamilyName(): ?string
    {
        if (count($this->familyName) == 0) {
            return null;
        }
        return $this->familyName['value'];
    }

    /**
     * Sets Family Name.
     * The family name (that is, the last name) associated with the team member.
     *
     * @maps family_name
     */
    public function setFamilyName(?string $familyName): void
    {
        $this->familyName['value'] = $familyName;
    }

    /**
     * Unsets Family Name.
     * The family name (that is, the last name) associated with the team member.
     */
    public function unsetFamilyName(): void
    {
        $this->familyName = [];
    }

    /**
     * Returns Email Address.
     * The email address associated with the team member.
     */
    public function getEmailAddress(): ?string
    {
        if (count($this->emailAddress) == 0) {
            return null;
        }
        return $this->emailAddress['value'];
    }

    /**
     * Sets Email Address.
     * The email address associated with the team member.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * The email address associated with the team member.
     */
    public function unsetEmailAddress(): void
    {
        $this->emailAddress = [];
    }

    /**
     * Returns Phone Number.
     * The team member's phone number, in E.164 format. For example:
     * +14155552671 - the country code is 1 for US
     * +551155256325 - the country code is 55 for BR
     */
    public function getPhoneNumber(): ?string
    {
        if (count($this->phoneNumber) == 0) {
            return null;
        }
        return $this->phoneNumber['value'];
    }

    /**
     * Sets Phone Number.
     * The team member's phone number, in E.164 format. For example:
     * +14155552671 - the country code is 1 for US
     * +551155256325 - the country code is 55 for BR
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The team member's phone number, in E.164 format. For example:
     * +14155552671 - the country code is 1 for US
     * +551155256325 - the country code is 55 for BR
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Created At.
     * The timestamp, in RFC 3339 format, describing when the team member was created.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp, in RFC 3339 format, describing when the team member was created.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp, in RFC 3339 format, describing when the team member was last updated.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp, in RFC 3339 format, describing when the team member was last updated.
     * For example, "2018-10-04T04:00:00-07:00" or "2019-02-05T12:00:00Z".
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Assigned Locations.
     * An object that represents a team member's assignment to locations.
     */
    public function getAssignedLocations(): ?TeamMemberAssignedLocations
    {
        return $this->assignedLocations;
    }

    /**
     * Sets Assigned Locations.
     * An object that represents a team member's assignment to locations.
     *
     * @maps assigned_locations
     */
    public function setAssignedLocations(?TeamMemberAssignedLocations $assignedLocations): void
    {
        $this->assignedLocations = $assignedLocations;
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
        if (isset($this->id)) {
            $json['id']                 = $this->id;
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']       = $this->referenceId['value'];
        }
        if (isset($this->isOwner)) {
            $json['is_owner']           = $this->isOwner;
        }
        if (isset($this->status)) {
            $json['status']             = $this->status;
        }
        if (!empty($this->givenName)) {
            $json['given_name']         = $this->givenName['value'];
        }
        if (!empty($this->familyName)) {
            $json['family_name']        = $this->familyName['value'];
        }
        if (!empty($this->emailAddress)) {
            $json['email_address']      = $this->emailAddress['value'];
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']       = $this->phoneNumber['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']         = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']         = $this->updatedAt;
        }
        if (isset($this->assignedLocations)) {
            $json['assigned_locations'] = $this->assignedLocations;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
