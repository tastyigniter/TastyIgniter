<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentBalanceActivityDepositFeeDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $payoutId = [];

    /**
     * Returns Payout Id.
     * The ID of the payout that triggered this deposit fee activity.
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
     * The ID of the payout that triggered this deposit fee activity.
     *
     * @maps payout_id
     */
    public function setPayoutId(?string $payoutId): void
    {
        $this->payoutId['value'] = $payoutId;
    }

    /**
     * Unsets Payout Id.
     * The ID of the payout that triggered this deposit fee activity.
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
        if (!empty($this->payoutId)) {
            $json['payout_id'] = $this->payoutId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
