<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter events by the order associated with the event.
 */
class LoyaltyEventOrderFilter implements \JsonSerializable
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @param string $orderId
     */
    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns Order Id.
     * The ID of the [order](entity:Order) associated with the event.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the [order](entity:Order) associated with the event.
     *
     * @required
     * @maps order_id
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
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
        $json['order_id'] = $this->orderId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
