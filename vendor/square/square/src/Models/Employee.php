<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An employee object that is used by the external API.
 */
class Employee implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $firstName = [];

    /**
     * @var array
     */
    private $lastName = [];

    /**
     * @var array
     */
    private $email = [];

    /**
     * @var array
     */
    private $phoneNumber = [];

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
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * Returns Id.
     * UUID for this object.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * UUID for this object.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns First Name.
     * The employee's first name.
     */
    public function getFirstName(): ?string
    {
        if (count($this->firstName) == 0) {
            return null;
        }
        return $this->firstName['value'];
    }

    /**
     * Sets First Name.
     * The employee's first name.
     *
     * @maps first_name
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName['value'] = $firstName;
    }

    /**
     * Unsets First Name.
     * The employee's first name.
     */
    public function unsetFirstName(): void
    {
        $this->firstName = [];
    }

    /**
     * Returns Last Name.
     * The employee's last name.
     */
    public function getLastName(): ?string
    {
        if (count($this->lastName) == 0) {
            return null;
        }
        return $this->lastName['value'];
    }

    /**
     * Sets Last Name.
     * The employee's last name.
     *
     * @maps last_name
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName['value'] = $lastName;
    }

    /**
     * Unsets Last Name.
     * The employee's last name.
     */
    public function unsetLastName(): void
    {
        $this->lastName = [];
    }

    /**
     * Returns Email.
     * The employee's email address
     */
    public function getEmail(): ?string
    {
        if (count($this->email) == 0) {
            return null;
        }
        return $this->email['value'];
    }

    /**
     * Sets Email.
     * The employee's email address
     *
     * @maps email
     */
    public function setEmail(?string $email): void
    {
        $this->email['value'] = $email;
    }

    /**
     * Unsets Email.
     * The employee's email address
     */
    public function unsetEmail(): void
    {
        $this->email = [];
    }

    /**
     * Returns Phone Number.
     * The employee's phone number in E.164 format, i.e. "+12125554250"
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
     * The employee's phone number in E.164 format, i.e. "+12125554250"
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The employee's phone number in E.164 format, i.e. "+12125554250"
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Location Ids.
     * A list of location IDs where this employee has access to.
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
     * A list of location IDs where this employee has access to.
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
     * A list of location IDs where this employee has access to.
     */
    public function unsetLocationIds(): void
    {
        $this->locationIds = [];
    }

    /**
     * Returns Status.
     * The status of the Employee being retrieved.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * The status of the Employee being retrieved.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Is Owner.
     * Whether this employee is the owner of the merchant. Each merchant
     * has one owner employee, and that employee has full authority over
     * the account.
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
     * Whether this employee is the owner of the merchant. Each merchant
     * has one owner employee, and that employee has full authority over
     * the account.
     *
     * @maps is_owner
     */
    public function setIsOwner(?bool $isOwner): void
    {
        $this->isOwner['value'] = $isOwner;
    }

    /**
     * Unsets Is Owner.
     * Whether this employee is the owner of the merchant. Each merchant
     * has one owner employee, and that employee has full authority over
     * the account.
     */
    public function unsetIsOwner(): void
    {
        $this->isOwner = [];
    }

    /**
     * Returns Created At.
     * A read-only timestamp in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * A read-only timestamp in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * A read-only timestamp in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * A read-only timestamp in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
            $json['id']           = $this->id;
        }
        if (!empty($this->firstName)) {
            $json['first_name']   = $this->firstName['value'];
        }
        if (!empty($this->lastName)) {
            $json['last_name']    = $this->lastName['value'];
        }
        if (!empty($this->email)) {
            $json['email']        = $this->email['value'];
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number'] = $this->phoneNumber['value'];
        }
        if (!empty($this->locationIds)) {
            $json['location_ids'] = $this->locationIds['value'];
        }
        if (isset($this->status)) {
            $json['status']       = $this->status;
        }
        if (!empty($this->isOwner)) {
            $json['is_owner']     = $this->isOwner['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']   = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']   = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
