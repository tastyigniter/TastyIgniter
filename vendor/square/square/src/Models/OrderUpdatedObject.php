<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class OrderUpdatedObject implements \JsonSerializable
{
    /**
     * @var OrderUpdated|null
     */
    private $orderUpdated;

    /**
     * Returns Order Updated.
     */
    public function getOrderUpdated(): ?OrderUpdated
    {
        return $this->orderUpdated;
    }

    /**
     * Sets Order Updated.
     *
     * @maps order_updated
     */
    public function setOrderUpdated(?OrderUpdated $orderUpdated): void
    {
        $this->orderUpdated = $orderUpdated;
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
        if (isset($this->orderUpdated)) {
            $json['order_updated'] = $this->orderUpdated;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
