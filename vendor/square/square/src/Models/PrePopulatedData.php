<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes buyer data to prepopulate in the payment form.
 * For more information,
 * see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-
 * checkout-configurations).
 */
class PrePopulatedData implements \JsonSerializable
{
    /**
     * @var array
     */
    private $buyerEmail = [];

    /**
     * @var array
     */
    private $buyerPhoneNumber = [];

    /**
     * @var Address|null
     */
    private $buyerAddress;

    /**
     * Returns Buyer Email.
     * The buyer email to prepopulate in the payment form.
     */
    public function getBuyerEmail(): ?string
    {
        if (count($this->buyerEmail) == 0) {
            return null;
        }
        return $this->buyerEmail['value'];
    }

    /**
     * Sets Buyer Email.
     * The buyer email to prepopulate in the payment form.
     *
     * @maps buyer_email
     */
    public function setBuyerEmail(?string $buyerEmail): void
    {
        $this->buyerEmail['value'] = $buyerEmail;
    }

    /**
     * Unsets Buyer Email.
     * The buyer email to prepopulate in the payment form.
     */
    public function unsetBuyerEmail(): void
    {
        $this->buyerEmail = [];
    }

    /**
     * Returns Buyer Phone Number.
     * The buyer phone number to prepopulate in the payment form.
     */
    public function getBuyerPhoneNumber(): ?string
    {
        if (count($this->buyerPhoneNumber) == 0) {
            return null;
        }
        return $this->buyerPhoneNumber['value'];
    }

    /**
     * Sets Buyer Phone Number.
     * The buyer phone number to prepopulate in the payment form.
     *
     * @maps buyer_phone_number
     */
    public function setBuyerPhoneNumber(?string $buyerPhoneNumber): void
    {
        $this->buyerPhoneNumber['value'] = $buyerPhoneNumber;
    }

    /**
     * Unsets Buyer Phone Number.
     * The buyer phone number to prepopulate in the payment form.
     */
    public function unsetBuyerPhoneNumber(): void
    {
        $this->buyerPhoneNumber = [];
    }

    /**
     * Returns Buyer Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getBuyerAddress(): ?Address
    {
        return $this->buyerAddress;
    }

    /**
     * Sets Buyer Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps buyer_address
     */
    public function setBuyerAddress(?Address $buyerAddress): void
    {
        $this->buyerAddress = $buyerAddress;
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
        if (!empty($this->buyerEmail)) {
            $json['buyer_email']        = $this->buyerEmail['value'];
        }
        if (!empty($this->buyerPhoneNumber)) {
            $json['buyer_phone_number'] = $this->buyerPhoneNumber['value'];
        }
        if (isset($this->buyerAddress)) {
            $json['buyer_address']      = $this->buyerAddress;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
