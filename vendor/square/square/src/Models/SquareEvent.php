<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class SquareEvent implements \JsonSerializable
{
    /**
     * @var array
     */
    private $merchantId = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $type = [];

    /**
     * @var array
     */
    private $eventId = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var SquareEventData|null
     */
    private $data;

    /**
     * Returns Merchant Id.
     * The ID of the target merchant associated with the event.
     */
    public function getMerchantId(): ?string
    {
        if (count($this->merchantId) == 0) {
            return null;
        }
        return $this->merchantId['value'];
    }

    /**
     * Sets Merchant Id.
     * The ID of the target merchant associated with the event.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId['value'] = $merchantId;
    }

    /**
     * Unsets Merchant Id.
     * The ID of the target merchant associated with the event.
     */
    public function unsetMerchantId(): void
    {
        $this->merchantId = [];
    }

    /**
     * Returns Location Id.
     * The ID of the location associated with the event.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the location associated with the event.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the location associated with the event.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Type.
     * The type of event this represents.
     */
    public function getType(): ?string
    {
        if (count($this->type) == 0) {
            return null;
        }
        return $this->type['value'];
    }

    /**
     * Sets Type.
     * The type of event this represents.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type['value'] = $type;
    }

    /**
     * Unsets Type.
     * The type of event this represents.
     */
    public function unsetType(): void
    {
        $this->type = [];
    }

    /**
     * Returns Event Id.
     * A unique ID for the event.
     */
    public function getEventId(): ?string
    {
        if (count($this->eventId) == 0) {
            return null;
        }
        return $this->eventId['value'];
    }

    /**
     * Sets Event Id.
     * A unique ID for the event.
     *
     * @maps event_id
     */
    public function setEventId(?string $eventId): void
    {
        $this->eventId['value'] = $eventId;
    }

    /**
     * Unsets Event Id.
     * A unique ID for the event.
     */
    public function unsetEventId(): void
    {
        $this->eventId = [];
    }

    /**
     * Returns Created At.
     * Timestamp of when the event was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * Timestamp of when the event was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Data.
     */
    public function getData(): ?SquareEventData
    {
        return $this->data;
    }

    /**
     * Sets Data.
     *
     * @maps data
     */
    public function setData(?SquareEventData $data): void
    {
        $this->data = $data;
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
        if (!empty($this->merchantId)) {
            $json['merchant_id'] = $this->merchantId['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        if (!empty($this->type)) {
            $json['type']        = $this->type['value'];
        }
        if (!empty($this->eventId)) {
            $json['event_id']    = $this->eventId['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']  = $this->createdAt;
        }
        if (isset($this->data)) {
            $json['data']        = $this->data;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
