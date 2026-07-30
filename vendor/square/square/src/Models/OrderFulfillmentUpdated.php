<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class OrderFulfillmentUpdated implements \JsonSerializable
{
    /**
     * @var array
     */
    private $orderId = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string|null
     */
    private $state;

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
    private $fulfillmentUpdate = [];

    /**
     * Returns Order Id.
     * The order's unique ID.
     */
    public function getOrderId(): ?string
    {
        if (count($this->orderId) == 0) {
            return null;
        }
        return $this->orderId['value'];
    }

    /**
     * Sets Order Id.
     * The order's unique ID.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The order's unique ID.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
    }

    /**
     * Returns Version.
     * The version number, which is incremented each time an update is committed to the order.
     * Orders that were not created through the API do not include a version number and
     * therefore cannot be updated.
     *
     * [Read more about working with versions.](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders)
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version number, which is incremented each time an update is committed to the order.
     * Orders that were not created through the API do not include a version number and
     * therefore cannot be updated.
     *
     * [Read more about working with versions.](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders)
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Location Id.
     * The ID of the seller location that this order is associated with.
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
     * The ID of the seller location that this order is associated with.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the seller location that this order is associated with.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns State.
     * The state of the order.
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets State.
     * The state of the order.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * Returns Created At.
     * The timestamp for when the order was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp for when the order was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp for when the order was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp for when the order was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Fulfillment Update.
     * The fulfillments that were updated with this version change.
     *
     * @return OrderFulfillmentUpdatedUpdate[]|null
     */
    public function getFulfillmentUpdate(): ?array
    {
        if (count($this->fulfillmentUpdate) == 0) {
            return null;
        }
        return $this->fulfillmentUpdate['value'];
    }

    /**
     * Sets Fulfillment Update.
     * The fulfillments that were updated with this version change.
     *
     * @maps fulfillment_update
     *
     * @param OrderFulfillmentUpdatedUpdate[]|null $fulfillmentUpdate
     */
    public function setFulfillmentUpdate(?array $fulfillmentUpdate): void
    {
        $this->fulfillmentUpdate['value'] = $fulfillmentUpdate;
    }

    /**
     * Unsets Fulfillment Update.
     * The fulfillments that were updated with this version change.
     */
    public function unsetFulfillmentUpdate(): void
    {
        $this->fulfillmentUpdate = [];
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
        if (!empty($this->orderId)) {
            $json['order_id']           = $this->orderId['value'];
        }
        if (isset($this->version)) {
            $json['version']            = $this->version;
        }
        if (!empty($this->locationId)) {
            $json['location_id']        = $this->locationId['value'];
        }
        if (isset($this->state)) {
            $json['state']              = $this->state;
        }
        if (isset($this->createdAt)) {
            $json['created_at']         = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']         = $this->updatedAt;
        }
        if (!empty($this->fulfillmentUpdate)) {
            $json['fulfillment_update'] = $this->fulfillmentUpdate['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
