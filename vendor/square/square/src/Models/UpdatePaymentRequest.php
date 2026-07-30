<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a request to update a payment using
 * [UpdatePayment]($e/Payments/UpdatePayment).
 */
class UpdatePaymentRequest implements \JsonSerializable
{
    /**
     * @var Payment|null
     */
    private $payment;

    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Payment.
     * Represents a payment processed by the Square API.
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * Sets Payment.
     * Represents a payment processed by the Square API.
     *
     * @maps payment
     */
    public function setPayment(?Payment $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `UpdatePayment` request. Keys can be any valid string
     * but must be unique for every `UpdatePayment` request.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `UpdatePayment` request. Keys can be any valid string
     * but must be unique for every `UpdatePayment` request.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
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
        if (isset($this->payment)) {
            $json['payment']     = $this->payment;
        }
        $json['idempotency_key'] = $this->idempotencyKey;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
