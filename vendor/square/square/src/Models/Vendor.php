<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a supplier to a seller.
 */
class Vendor implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var array
     */
    private $contacts = [];

    /**
     * @var array
     */
    private $accountNumber = [];

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $status;

    /**
     * Returns Id.
     * A unique Square-generated ID for the [Vendor](entity:Vendor).
     * This field is required when attempting to update a [Vendor](entity:Vendor).
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique Square-generated ID for the [Vendor](entity:Vendor).
     * This field is required when attempting to update a [Vendor](entity:Vendor).
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Created At.
     * An RFC 3339-formatted timestamp that indicates when the
     * [Vendor](entity:Vendor) was created.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * An RFC 3339-formatted timestamp that indicates when the
     * [Vendor](entity:Vendor) was created.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * An RFC 3339-formatted timestamp that indicates when the
     * [Vendor](entity:Vendor) was last updated.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * An RFC 3339-formatted timestamp that indicates when the
     * [Vendor](entity:Vendor) was last updated.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Name.
     * The name of the [Vendor](entity:Vendor).
     * This field is required when attempting to create or update a [Vendor](entity:Vendor).
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
     * The name of the [Vendor](entity:Vendor).
     * This field is required when attempting to create or update a [Vendor](entity:Vendor).
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the [Vendor](entity:Vendor).
     * This field is required when attempting to create or update a [Vendor](entity:Vendor).
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Sets Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    /**
     * Returns Contacts.
     * The contacts of the [Vendor](entity:Vendor).
     *
     * @return VendorContact[]|null
     */
    public function getContacts(): ?array
    {
        if (count($this->contacts) == 0) {
            return null;
        }
        return $this->contacts['value'];
    }

    /**
     * Sets Contacts.
     * The contacts of the [Vendor](entity:Vendor).
     *
     * @maps contacts
     *
     * @param VendorContact[]|null $contacts
     */
    public function setContacts(?array $contacts): void
    {
        $this->contacts['value'] = $contacts;
    }

    /**
     * Unsets Contacts.
     * The contacts of the [Vendor](entity:Vendor).
     */
    public function unsetContacts(): void
    {
        $this->contacts = [];
    }

    /**
     * Returns Account Number.
     * The account number of the [Vendor](entity:Vendor).
     */
    public function getAccountNumber(): ?string
    {
        if (count($this->accountNumber) == 0) {
            return null;
        }
        return $this->accountNumber['value'];
    }

    /**
     * Sets Account Number.
     * The account number of the [Vendor](entity:Vendor).
     *
     * @maps account_number
     */
    public function setAccountNumber(?string $accountNumber): void
    {
        $this->accountNumber['value'] = $accountNumber;
    }

    /**
     * Unsets Account Number.
     * The account number of the [Vendor](entity:Vendor).
     */
    public function unsetAccountNumber(): void
    {
        $this->accountNumber = [];
    }

    /**
     * Returns Note.
     * A note detailing information about the [Vendor](entity:Vendor).
     */
    public function getNote(): ?string
    {
        if (count($this->note) == 0) {
            return null;
        }
        return $this->note['value'];
    }

    /**
     * Sets Note.
     * A note detailing information about the [Vendor](entity:Vendor).
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * A note detailing information about the [Vendor](entity:Vendor).
     */
    public function unsetNote(): void
    {
        $this->note = [];
    }

    /**
     * Returns Version.
     * The version of the [Vendor](entity:Vendor).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version of the [Vendor](entity:Vendor).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Status.
     * The status of the [Vendor]($m/Vendor),
     * whether a [Vendor]($m/Vendor) is active or inactive.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * The status of the [Vendor]($m/Vendor),
     * whether a [Vendor]($m/Vendor) is active or inactive.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
            $json['id']             = $this->id;
        }
        if (isset($this->createdAt)) {
            $json['created_at']     = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']     = $this->updatedAt;
        }
        if (!empty($this->name)) {
            $json['name']           = $this->name['value'];
        }
        if (isset($this->address)) {
            $json['address']        = $this->address;
        }
        if (!empty($this->contacts)) {
            $json['contacts']       = $this->contacts['value'];
        }
        if (!empty($this->accountNumber)) {
            $json['account_number'] = $this->accountNumber['value'];
        }
        if (!empty($this->note)) {
            $json['note']           = $this->note['value'];
        }
        if (isset($this->version)) {
            $json['version']        = $this->version;
        }
        if (isset($this->status)) {
            $json['status']         = $this->status;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
