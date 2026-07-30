<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in requests to the
 * `BatchRetrieveOrders` endpoint.
 */
class BatchRetrieveOrdersRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string[]
     */
    private $orderIds;

    /**
     * @param string[] $orderIds
     */
    public function __construct(array $orderIds)
    {
        $this->orderIds = $orderIds;
    }

    /**
     * Returns Location Id.
     * The ID of the location for these orders. This field is optional: omit it to retrieve
     * orders within the scope of the current authorization's merchant ID.
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
     * The ID of the location for these orders. This field is optional: omit it to retrieve
     * orders within the scope of the current authorization's merchant ID.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the location for these orders. This field is optional: omit it to retrieve
     * orders within the scope of the current authorization's merchant ID.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Order Ids.
     * The IDs of the orders to retrieve. A maximum of 100 orders can be retrieved per request.
     *
     * @return string[]
     */
    public function getOrderIds(): array
    {
        return $this->orderIds;
    }

    /**
     * Sets Order Ids.
     * The IDs of the orders to retrieve. A maximum of 100 orders can be retrieved per request.
     *
     * @required
     * @maps order_ids
     *
     * @param string[] $orderIds
     */
    public function setOrderIds(array $orderIds): void
    {
        $this->orderIds = $orderIds;
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
        if (!empty($this->locationId)) {
            $json['location_id'] = $this->locationId['value'];
        }
        $json['order_ids']       = $this->orderIds;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
