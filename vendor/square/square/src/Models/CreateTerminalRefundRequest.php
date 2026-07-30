<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateTerminalRefundRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var TerminalRefund|null
     */
    private $refund;

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreateRefund` request. Keys can be any valid string but
     * must be unique for every `CreateRefund` request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more
     * information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreateRefund` request. Keys can be any valid string but
     * must be unique for every `CreateRefund` request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more
     * information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Refund.
     * Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit
     * network) payment refunds.
     */
    public function getRefund(): ?TerminalRefund
    {
        return $this->refund;
    }

    /**
     * Sets Refund.
     * Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit
     * network) payment refunds.
     *
     * @maps refund
     */
    public function setRefund(?TerminalRefund $refund): void
    {
        $this->refund = $refund;
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
        $json['idempotency_key'] = $this->idempotencyKey;
        if (isset($this->refund)) {
            $json['refund']      = $this->refund;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
