<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in requests to the
 * [UpdateOrder]($e/Orders/UpdateOrder) endpoint.
 */
class UpdateOrderRequest implements \JsonSerializable
{
    /**
     * @var Order|null
     */
    private $order;

    /**
     * @var array
     */
    private $fieldsToClear = [];

    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * Returns Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * Sets Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     *
     * @maps order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Fields to Clear.
     * The [dot notation paths](https://developer.squareup.com/docs/orders-api/manage-orders/update-
     * orders#identifying-fields-to-delete)
     * fields to clear. For example, `line_items[uid].note`.
     * For more information, see [Deleting fields](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders#deleting-fields).
     *
     * @return string[]|null
     */
    public function getFieldsToClear(): ?array
    {
        if (count($this->fieldsToClear) == 0) {
            return null;
        }
        return $this->fieldsToClear['value'];
    }

    /**
     * Sets Fields to Clear.
     * The [dot notation paths](https://developer.squareup.com/docs/orders-api/manage-orders/update-
     * orders#identifying-fields-to-delete)
     * fields to clear. For example, `line_items[uid].note`.
     * For more information, see [Deleting fields](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders#deleting-fields).
     *
     * @maps fields_to_clear
     *
     * @param string[]|null $fieldsToClear
     */
    public function setFieldsToClear(?array $fieldsToClear): void
    {
        $this->fieldsToClear['value'] = $fieldsToClear;
    }

    /**
     * Unsets Fields to Clear.
     * The [dot notation paths](https://developer.squareup.com/docs/orders-api/manage-orders/update-
     * orders#identifying-fields-to-delete)
     * fields to clear. For example, `line_items[uid].note`.
     * For more information, see [Deleting fields](https://developer.squareup.com/docs/orders-api/manage-
     * orders/update-orders#deleting-fields).
     */
    public function unsetFieldsToClear(): void
    {
        $this->fieldsToClear = [];
    }

    /**
     * Returns Idempotency Key.
     * A value you specify that uniquely identifies this update request.
     *
     * If you are unsure whether a particular update was applied to an order successfully,
     * you can reattempt it with the same idempotency key without
     * worrying about creating duplicate updates to the order.
     * The latest order version is returned.
     *
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
     * A value you specify that uniquely identifies this update request.
     *
     * If you are unsure whether a particular update was applied to an order successfully,
     * you can reattempt it with the same idempotency key without
     * worrying about creating duplicate updates to the order.
     * The latest order version is returned.
     *
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
     * A value you specify that uniquely identifies this update request.
     *
     * If you are unsure whether a particular update was applied to an order successfully,
     * you can reattempt it with the same idempotency key without
     * worrying about creating duplicate updates to the order.
     * The latest order version is returned.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        if (isset($this->order)) {
            $json['order']           = $this->order;
        }
        if (!empty($this->fieldsToClear)) {
            $json['fields_to_clear'] = $this->fieldsToClear['value'];
        }
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
