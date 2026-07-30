<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Additional details about a Buy Now Pay Later payment type.
 */
class BuyNowPayLaterDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $brand = [];

    /**
     * @var AfterpayDetails|null
     */
    private $afterpayDetails;

    /**
     * @var ClearpayDetails|null
     */
    private $clearpayDetails;

    /**
     * Returns Brand.
     * The brand used for the Buy Now Pay Later payment.
     * The brand can be `AFTERPAY`, `CLEARPAY` or `UNKNOWN`.
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
     * The brand used for the Buy Now Pay Later payment.
     * The brand can be `AFTERPAY`, `CLEARPAY` or `UNKNOWN`.
     *
     * @maps brand
     */
    public function setBrand(?string $brand): void
    {
        $this->brand['value'] = $brand;
    }

    /**
     * Unsets Brand.
     * The brand used for the Buy Now Pay Later payment.
     * The brand can be `AFTERPAY`, `CLEARPAY` or `UNKNOWN`.
     */
    public function unsetBrand(): void
    {
        $this->brand = [];
    }

    /**
     * Returns Afterpay Details.
     * Additional details about Afterpay payments.
     */
    public function getAfterpayDetails(): ?AfterpayDetails
    {
        return $this->afterpayDetails;
    }

    /**
     * Sets Afterpay Details.
     * Additional details about Afterpay payments.
     *
     * @maps afterpay_details
     */
    public function setAfterpayDetails(?AfterpayDetails $afterpayDetails): void
    {
        $this->afterpayDetails = $afterpayDetails;
    }

    /**
     * Returns Clearpay Details.
     * Additional details about Clearpay payments.
     */
    public function getClearpayDetails(): ?ClearpayDetails
    {
        return $this->clearpayDetails;
    }

    /**
     * Sets Clearpay Details.
     * Additional details about Clearpay payments.
     *
     * @maps clearpay_details
     */
    public function setClearpayDetails(?ClearpayDetails $clearpayDetails): void
    {
        $this->clearpayDetails = $clearpayDetails;
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
        if (!empty($this->brand)) {
            $json['brand']            = $this->brand['value'];
        }
        if (isset($this->afterpayDetails)) {
            $json['afterpay_details'] = $this->afterpayDetails;
        }
        if (isset($this->clearpayDetails)) {
            $json['clearpay_details'] = $this->clearpayDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
