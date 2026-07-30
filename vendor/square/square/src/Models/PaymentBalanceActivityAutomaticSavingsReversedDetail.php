<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentBalanceActivityAutomaticSavingsReversedDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $payoutId = [];

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
     * Returns Payout Id.
     * The ID of the payout associated with this activity.
     */
    public function getPayoutId(): ?string
    {
        if (count($this->payoutId) == 0) {
            return null;
        }
        return $this->payoutId['value'];
    }

    /**
     * Sets Payout Id.
     * The ID of the payout associated with this activity.
     *
     * @maps payout_id
     */
    public function setPayoutId(?string $payoutId): void
    {
        $this->payoutId['value'] = $payoutId;
    }

    /**
     * Unsets Payout Id.
     * The ID of the payout associated with this activity.
     */
    public function unsetPayoutId(): void
    {
        $this->payoutId = [];
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
        if (!empty($this->payoutId)) {
            $json['payout_id']  = $this->payoutId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
