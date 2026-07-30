<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a contact of a [Vendor]($m/Vendor).
 */
class VendorContact implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $emailAddress = [];

    /**
     * @var array
     */
    private $phoneNumber = [];

    /**
     * @var array
     */
    private $removed = [];

    /**
     * @var int
     */
    private $ordinal;

    /**
     * @param int $ordinal
     */
    public function __construct(int $ordinal)
    {
        $this->ordinal = $ordinal;
    }

    /**
     * Returns Id.
     * A unique Square-generated ID for the [VendorContact](entity:VendorContact).
     * This field is required when attempting to update a [VendorContact](entity:VendorContact).
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique Square-generated ID for the [VendorContact](entity:VendorContact).
     * This field is required when attempting to update a [VendorContact](entity:VendorContact).
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     * The name of the [VendorContact](entity:VendorContact).
     * This field is required when attempting to create a [Vendor](entity:Vendor).
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The name of the [VendorContact](entity:VendorContact).
     * This field is required when attempting to create a [Vendor](entity:Vendor).
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the [VendorContact](entity:VendorContact).
     * This field is required when attempting to create a [Vendor](entity:Vendor).
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Email Address.
     * The email address of the [VendorContact](entity:VendorContact).
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
     * The email address of the [VendorContact](entity:VendorContact).
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * The email address of the [VendorContact](entity:VendorContact).
     */
    public function unsetEmailAddress(): void
    {
        $this->emailAddress = [];
    }

    /**
     * Returns Phone Number.
     * The phone number of the [VendorContact](entity:VendorContact).
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
     * The phone number of the [VendorContact](entity:VendorContact).
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number of the [VendorContact](entity:VendorContact).
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Removed.
     * The state of the [VendorContact](entity:VendorContact).
     */
    public function getRemoved(): ?bool
    {
        if (count($this->removed) == 0) {
            return null;
        }
        return $this->removed['value'];
    }

    /**
     * Sets Removed.
     * The state of the [VendorContact](entity:VendorContact).
     *
     * @maps removed
     */
    public function setRemoved(?bool $removed): void
    {
        $this->removed['value'] = $removed;
    }

    /**
     * Unsets Removed.
     * The state of the [VendorContact](entity:VendorContact).
     */
    public function unsetRemoved(): void
    {
        $this->removed = [];
    }

    /**
     * Returns Ordinal.
     * The ordinal of the [VendorContact](entity:VendorContact).
     */
    public function getOrdinal(): int
    {
        return $this->ordinal;
    }

    /**
     * Sets Ordinal.
     * The ordinal of the [VendorContact](entity:VendorContact).
     *
     * @required
     * @maps ordinal
     */
    public function setOrdinal(int $ordinal): void
    {
        $this->ordinal = $ordinal;
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
            $json['id']            = $this->id;
        }
        if (!empty($this->name)) {
            $json['name']          = $this->name['value'];
        }
        if (!empty($this->emailAddress)) {
            $json['email_address'] = $this->emailAddress['value'];
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']  = $this->phoneNumber['value'];
        }
        if (!empty($this->removed)) {
            $json['removed']       = $this->removed['value'];
        }
        $json['ordinal']           = $this->ordinal;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
