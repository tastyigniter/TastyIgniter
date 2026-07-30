<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentBalanceActivityTaxOnFeeDetail implements \JsonSerializable
{
    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $taxRateDescription = [];

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
     * Returns Tax Rate Description.
     * The description of the tax rate being applied. For example: "GST", "HST".
     */
    public function getTaxRateDescription(): ?string
    {
        if (count($this->taxRateDescription) == 0) {
            return null;
        }
        return $this->taxRateDescription['value'];
    }

    /**
     * Sets Tax Rate Description.
     * The description of the tax rate being applied. For example: "GST", "HST".
     *
     * @maps tax_rate_description
     */
    public function setTaxRateDescription(?string $taxRateDescription): void
    {
        $this->taxRateDescription['value'] = $taxRateDescription;
    }

    /**
     * Unsets Tax Rate Description.
     * The description of the tax rate being applied. For example: "GST", "HST".
     */
    public function unsetTaxRateDescription(): void
    {
        $this->taxRateDescription = [];
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
            $json['payment_id']           = $this->paymentId['value'];
        }
        if (!empty($this->taxRateDescription)) {
            $json['tax_rate_description'] = $this->taxRateDescription['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
