<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentBalanceActivityRefundDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $refundId = [];

    /**
     * Returns Payment Id.
     * The ID of the payment associated with this activity.
     */
    public function getPaymentId(): ?string
    {
        if (count($this->paymentId) == 0) {
            return null;
        }
        return $this->paymentId['value'];
    }

    /**
     * Sets Payment Id.
     * The ID of the payment associated with this activity.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId['value'] = $paymentId;
    }

    /**
     * Unsets Payment Id.
     * The ID of the payment associated with this activity.
     */
    public function unsetPaymentId(): void
    {
        $this->paymentId = [];
    }

    /**
     * Returns Refund Id.
     * The ID of the refund associated with this activity.
     */
    public function getRefundId(): ?string
    {
        if (count($this->refundId) == 0) {
            return null;
        }
        return $this->refundId['value'];
    }

    /**
     * Sets Refund Id.
     * The ID of the refund associated with this activity.
     *
     * @maps refund_id
     */
    public function setRefundId(?string $refundId): void
    {
        $this->refundId['value'] = $refundId;
    }

    /**
     * Unsets Refund Id.
     * The ID of the refund associated with this activity.
     */
    public function unsetRefundId(): void
    {
        $this->refundId = [];
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
        if (!empty($this->paymentId)) {
            $json['payment_id'] = $this->paymentId['value'];
        }
        if (!empty($this->refundId)) {
            $json['refund_id']  = $this->refundId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
