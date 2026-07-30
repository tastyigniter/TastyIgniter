<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the mapping that associates a loyalty account with a buyer.
 *
 * Currently, a loyalty account can only be mapped to a buyer by phone number. For more information,
 * see
 * [Loyalty Overview](https://developer.squareup.com/docs/loyalty/overview).
 */
class LoyaltyAccountMapping implements \JsonSerializable
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
     * @var array
     */
    private $phoneNumber = [];

    /**
     * Returns Id.
     * The Square-assigned ID of the mapping.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the mapping.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Created At.
     * The timestamp when the mapping was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the mapping was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Phone Number.
     * The phone number of the buyer, in E.164 format. For example, "+14155551111".
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
     * The phone number of the buyer, in E.164 format. For example, "+14155551111".
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number of the buyer, in E.164 format. For example, "+14155551111".
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
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
        if (isset($this->createdAt)) {
            $json['created_at']   = $this->createdAt;
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number'] = $this->phoneNumber['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
