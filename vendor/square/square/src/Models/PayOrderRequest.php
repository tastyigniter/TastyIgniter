<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in requests to the
 * [PayOrder]($e/Orders/PayOrder) endpoint.
 */
class PayOrderRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var array
     */
    private $orderVersion = [];

    /**
     * @var array
     */
    private $paymentIds = [];

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Idempotency Key.
     * A value you specify that uniquely identifies this request among requests you have sent. If
     * you are unsure whether a particular payment request was completed successfully, you can reattempt
     * it with the same idempotency key without worrying about duplicate payments.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A value you specify that uniquely identifies this request among requests you have sent. If
     * you are unsure whether a particular payment request was completed successfully, you can reattempt
     * it with the same idempotency key without worrying about duplicate payments.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Order Version.
     * The version of the order being paid. If not supplied, the latest version will be paid.
     */
    public function getOrderVersion(): ?int
    {
        if (count($this->orderVersion) == 0) {
            return null;
        }
        return $this->orderVersion['value'];
    }

    /**
     * Sets Order Version.
     * The version of the order being paid. If not supplied, the latest version will be paid.
     *
     * @maps order_version
     */
    public function setOrderVersion(?int $orderVersion): void
    {
        $this->orderVersion['value'] = $orderVersion;
    }

    /**
     * Unsets Order Version.
     * The version of the order being paid. If not supplied, the latest version will be paid.
     */
    public function unsetOrderVersion(): void
    {
        $this->orderVersion = [];
    }

    /**
     * Returns Payment Ids.
     * The IDs of the [payments](entity:Payment) to collect.
     * The payment total must match the order total.
     *
     * @return string[]|null
     */
    public function getPaymentIds(): ?array
    {
        if (count($this->paymentIds) == 0) {
            return null;
        }
        return $this->paymentIds['value'];
    }

    /**
     * Sets Payment Ids.
     * The IDs of the [payments](entity:Payment) to collect.
     * The payment total must match the order total.
     *
     * @maps payment_ids
     *
     * @param string[]|null $paymentIds
     */
    public function setPaymentIds(?array $paymentIds): void
    {
        $this->paymentIds['value'] = $paymentIds;
    }

    /**
     * Unsets Payment Ids.
     * The IDs of the [payments](entity:Payment) to collect.
     * The payment total must match the order total.
     */
    public function unsetPaymentIds(): void
    {
        $this->paymentIds = [];
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
        $json['idempotency_key']   = $this->idempotencyKey;
        if (!empty($this->orderVersion)) {
            $json['order_version'] = $this->orderVersion['value'];
        }
        if (!empty($this->paymentIds)) {
            $json['payment_ids']   = $this->paymentIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
