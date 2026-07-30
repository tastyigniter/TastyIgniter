<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentBalanceActivityDisputeDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $disputeId = [];

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
     * Returns Dispute Id.
     * The ID of the dispute associated with this activity.
     */
    public function getDisputeId(): ?string
    {
        if (count($this->disputeId) == 0) {
            return null;
        }
        return $this->disputeId['value'];
    }

    /**
     * Sets Dispute Id.
     * The ID of the dispute associated with this activity.
     *
     * @maps dispute_id
     */
    public function setDisputeId(?string $disputeId): void
    {
        $this->disputeId['value'] = $disputeId;
    }

    /**
     * Unsets Dispute Id.
     * The ID of the dispute associated with this activity.
     */
    public function unsetDisputeId(): void
    {
        $this->disputeId = [];
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
        if (!empty($this->disputeId)) {
            $json['dispute_id'] = $this->disputeId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
