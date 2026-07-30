<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A lightweight description of an [order]($m/Order) that is returned when
 * `returned_entries` is `true` on a [SearchOrdersRequest]($e/Orders/SearchOrders).
 */
class OrderEntry implements \JsonSerializable
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
     * Returns Order Id.
     * The ID of the order.
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
     * The ID of the order.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The ID of the order.
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
     * The location ID the order belongs to.
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
     * The location ID the order belongs to.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The location ID the order belongs to.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
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
            $json['order_id']    = $this->orderId['value'];
        }
        if (isset($this->version)) {
            $json['version']     = $this->version;
        }
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
