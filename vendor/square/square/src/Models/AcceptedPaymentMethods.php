<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class AcceptedPaymentMethods implements \JsonSerializable
{
    /**
     * @var array
     */
    private $applePay = [];

    /**
     * @var array
     */
    private $googlePay = [];

    /**
     * @var array
     */
    private $cashAppPay = [];

    /**
     * @var array
     */
    private $afterpayClearpay = [];

    /**
     * Returns Apple Pay.
     * Whether Apple Pay is accepted at checkout.
     */
    public function getApplePay(): ?bool
    {
        if (count($this->applePay) == 0) {
            return null;
        }
        return $this->applePay['value'];
    }

    /**
     * Sets Apple Pay.
     * Whether Apple Pay is accepted at checkout.
     *
     * @maps apple_pay
     */
    public function setApplePay(?bool $applePay): void
    {
        $this->applePay['value'] = $applePay;
    }

    /**
     * Unsets Apple Pay.
     * Whether Apple Pay is accepted at checkout.
     */
    public function unsetApplePay(): void
    {
        $this->applePay = [];
    }

    /**
     * Returns Google Pay.
     * Whether Google Pay is accepted at checkout.
     */
    public function getGooglePay(): ?bool
    {
        if (count($this->googlePay) == 0) {
            return null;
        }
        return $this->googlePay['value'];
    }

    /**
     * Sets Google Pay.
     * Whether Google Pay is accepted at checkout.
     *
     * @maps google_pay
     */
    public function setGooglePay(?bool $googlePay): void
    {
        $this->googlePay['value'] = $googlePay;
    }

    /**
     * Unsets Google Pay.
     * Whether Google Pay is accepted at checkout.
     */
    public function unsetGooglePay(): void
    {
        $this->googlePay = [];
    }

    /**
     * Returns Cash App Pay.
     * Whether Cash App Pay is accepted at checkout.
     */
    public function getCashAppPay(): ?bool
    {
        if (count($this->cashAppPay) == 0) {
            return null;
        }
        return $this->cashAppPay['value'];
    }

    /**
     * Sets Cash App Pay.
     * Whether Cash App Pay is accepted at checkout.
     *
     * @maps cash_app_pay
     */
    public function setCashAppPay(?bool $cashAppPay): void
    {
        $this->cashAppPay['value'] = $cashAppPay;
    }

    /**
     * Unsets Cash App Pay.
     * Whether Cash App Pay is accepted at checkout.
     */
    public function unsetCashAppPay(): void
    {
        $this->cashAppPay = [];
    }

    /**
     * Returns Afterpay Clearpay.
     * Whether Afterpay/Clearpay is accepted at checkout.
     */
    public function getAfterpayClearpay(): ?bool
    {
        if (count($this->afterpayClearpay) == 0) {
            return null;
        }
        return $this->afterpayClearpay['value'];
    }

    /**
     * Sets Afterpay Clearpay.
     * Whether Afterpay/Clearpay is accepted at checkout.
     *
     * @maps afterpay_clearpay
     */
    public function setAfterpayClearpay(?bool $afterpayClearpay): void
    {
        $this->afterpayClearpay['value'] = $afterpayClearpay;
    }

    /**
     * Unsets Afterpay Clearpay.
     * Whether Afterpay/Clearpay is accepted at checkout.
     */
    public function unsetAfterpayClearpay(): void
    {
        $this->afterpayClearpay = [];
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
        if (!empty($this->applePay)) {
            $json['apple_pay']         = $this->applePay['value'];
        }
        if (!empty($this->googlePay)) {
            $json['google_pay']        = $this->googlePay['value'];
        }
        if (!empty($this->cashAppPay)) {
            $json['cash_app_pay']      = $this->cashAppPay['value'];
        }
        if (!empty($this->afterpayClearpay)) {
            $json['afterpay_clearpay'] = $this->afterpayClearpay['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
