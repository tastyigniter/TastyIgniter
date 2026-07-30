<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class OrderFulfillmentUpdatedObject implements \JsonSerializable
{
    /**
     * @var OrderFulfillmentUpdated|null
     */
    private $orderFulfillmentUpdated;

    /**
     * Returns Order Fulfillment Updated.
     */
    public function getOrderFulfillmentUpdated(): ?OrderFulfillmentUpdated
    {
        return $this->orderFulfillmentUpdated;
    }

    /**
     * Sets Order Fulfillment Updated.
     *
     * @maps order_fulfillment_updated
     */
    public function setOrderFulfillmentUpdated(?OrderFulfillmentUpdated $orderFulfillmentUpdated): void
    {
        $this->orderFulfillmentUpdated = $orderFulfillmentUpdated;
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
        if (isset($this->orderFulfillmentUpdated)) {
            $json['order_fulfillment_updated'] = $this->orderFulfillmentUpdated;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
