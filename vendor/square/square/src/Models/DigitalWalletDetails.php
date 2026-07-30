<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Additional details about `WALLET` type payments. Contains only non-confidential information.
 */
class DigitalWalletDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $status = [];

    /**
     * @var array
     */
    private $brand = [];

    /**
     * @var CashAppDetails|null
     */
    private $cashAppDetails;

    /**
     * Returns Status.
     * The status of the `WALLET` payment. The status can be `AUTHORIZED`, `CAPTURED`, `VOIDED`, or
     * `FAILED`.
     */
    public function getStatus(): ?string
    {
        if (count($this->status) == 0) {
            return null;
        }
        return $this->status['value'];
    }

    /**
     * Sets Status.
     * The status of the `WALLET` payment. The status can be `AUTHORIZED`, `CAPTURED`, `VOIDED`, or
     * `FAILED`.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status['value'] = $status;
    }

    /**
     * Unsets Status.
     * The status of the `WALLET` payment. The status can be `AUTHORIZED`, `CAPTURED`, `VOIDED`, or
     * `FAILED`.
     */
    public function unsetStatus(): void
    {
        $this->status = [];
    }

    /**
     * Returns Brand.
     * The brand used for the `WALLET` payment. The brand can be `CASH_APP`, `PAYPAY` or `UNKNOWN`.
     */
    public function getBrand(): ?string
    {
        if (count($this->brand) == 0) {
            return null;
        }
        return $this->brand['value'];
    }

    /**
     * Sets Brand.
     * The brand used for the `WALLET` payment. The brand can be `CASH_APP`, `PAYPAY` or `UNKNOWN`.
     *
     * @maps brand
     */
    public function setBrand(?string $brand): void
    {
        $this->brand['value'] = $brand;
    }

    /**
     * Unsets Brand.
     * The brand used for the `WALLET` payment. The brand can be `CASH_APP`, `PAYPAY` or `UNKNOWN`.
     */
    public function unsetBrand(): void
    {
        $this->brand = [];
    }

    /**
     * Returns Cash App Details.
     * Additional details about `WALLET` type payments with the `brand` of `CASH_APP`.
     */
    public function getCashAppDetails(): ?CashAppDetails
    {
        return $this->cashAppDetails;
    }

    /**
     * Sets Cash App Details.
     * Additional details about `WALLET` type payments with the `brand` of `CASH_APP`.
     *
     * @maps cash_app_details
     */
    public function setCashAppDetails(?CashAppDetails $cashAppDetails): void
    {
        $this->cashAppDetails = $cashAppDetails;
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
        if (!empty($this->status)) {
            $json['status']           = $this->status['value'];
        }
        if (!empty($this->brand)) {
            $json['brand']            = $this->brand['value'];
        }
        if (isset($this->cashAppDetails)) {
            $json['cash_app_details'] = $this->cashAppDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
