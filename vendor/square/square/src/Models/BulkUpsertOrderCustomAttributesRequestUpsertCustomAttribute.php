<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents one upsert within the bulk operation.
 */
class BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute implements \JsonSerializable
{
    /**
     * @var CustomAttribute
     */
    private $customAttribute;

    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @var string
     */
    private $orderId;

    /**
     * @param CustomAttribute $customAttribute
     * @param string $orderId
     */
    public function __construct(CustomAttribute $customAttribute, string $orderId)
    {
        $this->customAttribute = $customAttribute;
        $this->orderId = $orderId;
    }

    /**
     * Returns Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     */
    public function getCustomAttribute(): CustomAttribute
    {
        return $this->customAttribute;
    }

    /**
     * Sets Custom Attribute.
     * A custom attribute value. Each custom attribute value has a corresponding
     * `CustomAttributeDefinition` object.
     *
     * @required
     * @maps custom_attribute
     */
    public function setCustomAttribute(CustomAttribute $customAttribute): void
    {
        $this->customAttribute = $customAttribute;
    }

    /**
     * Returns Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency.
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
    }

    /**
     * Sets Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency.
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency.
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        $json['custom_attribute']    = $this->customAttribute;
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json['order_id']            = $this->orderId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
