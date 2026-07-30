<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents one delete within the bulk operation.
 */
class BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $key;

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
     * Returns Key.
     * The key of the custom attribute to delete.  This key must match the key
     * of an existing custom attribute definition.
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Sets Key.
     * The key of the custom attribute to delete.  This key must match the key
     * of an existing custom attribute definition.
     *
     * @maps key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    /**
     * Returns Order Id.
     * The ID of the target [order](entity:Order).
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the target [order](entity:Order).
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
        if (isset($this->key)) {
            $json['key']  = $this->key;
        }
        $json['order_id'] = $this->orderId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
