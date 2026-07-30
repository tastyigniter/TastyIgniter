<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class OrderCreatedObject implements \JsonSerializable
{
    /**
     * @var OrderCreated|null
     */
    private $orderCreated;

    /**
     * Returns Order Created.
     */
    public function getOrderCreated(): ?OrderCreated
    {
        return $this->orderCreated;
    }

    /**
     * Sets Order Created.
     *
     * @maps order_created
     */
    public function setOrderCreated(?OrderCreated $orderCreated): void
    {
        $this->orderCreated = $orderCreated;
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
        if (isset($this->orderCreated)) {
            $json['order_created'] = $this->orderCreated;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
