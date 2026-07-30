<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Additional details about `WALLET` type payments with the `brand` of `CASH_APP`.
 */
class CashAppDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $buyerFullName = [];

    /**
     * @var array
     */
    private $buyerCountryCode = [];

    /**
     * @var string|null
     */
    private $buyerCashtag;

    /**
     * Returns Buyer Full Name.
     * The name of the Cash App account holder.
     */
    public function getBuyerFullName(): ?string
    {
        if (count($this->buyerFullName) == 0) {
            return null;
        }
        return $this->buyerFullName['value'];
    }

    /**
     * Sets Buyer Full Name.
     * The name of the Cash App account holder.
     *
     * @maps buyer_full_name
     */
    public function setBuyerFullName(?string $buyerFullName): void
    {
        $this->buyerFullName['value'] = $buyerFullName;
    }

    /**
     * Unsets Buyer Full Name.
     * The name of the Cash App account holder.
     */
    public function unsetBuyerFullName(): void
    {
        $this->buyerFullName = [];
    }

    /**
     * Returns Buyer Country Code.
     * The country of the Cash App account holder, in ISO 3166-1-alpha-2 format.
     *
     * For possible values, see [Country](entity:Country).
     */
    public function getBuyerCountryCode(): ?string
    {
        if (count($this->buyerCountryCode) == 0) {
            return null;
        }
        return $this->buyerCountryCode['value'];
    }

    /**
     * Sets Buyer Country Code.
     * The country of the Cash App account holder, in ISO 3166-1-alpha-2 format.
     *
     * For possible values, see [Country](entity:Country).
     *
     * @maps buyer_country_code
     */
    public function setBuyerCountryCode(?string $buyerCountryCode): void
    {
        $this->buyerCountryCode['value'] = $buyerCountryCode;
    }

    /**
     * Unsets Buyer Country Code.
     * The country of the Cash App account holder, in ISO 3166-1-alpha-2 format.
     *
     * For possible values, see [Country](entity:Country).
     */
    public function unsetBuyerCountryCode(): void
    {
        $this->buyerCountryCode = [];
    }

    /**
     * Returns Buyer Cashtag.
     * $Cashtag of the Cash App account holder.
     */
    public function getBuyerCashtag(): ?string
    {
        return $this->buyerCashtag;
    }

    /**
     * Sets Buyer Cashtag.
     * $Cashtag of the Cash App account holder.
     *
     * @maps buyer_cashtag
     */
    public function setBuyerCashtag(?string $buyerCashtag): void
    {
        $this->buyerCashtag = $buyerCashtag;
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
        if (!empty($this->buyerFullName)) {
            $json['buyer_full_name']    = $this->buyerFullName['value'];
        }
        if (!empty($this->buyerCountryCode)) {
            $json['buyer_country_code'] = $this->buyerCountryCode['value'];
        }
        if (isset($this->buyerCashtag)) {
            $json['buyer_cashtag']      = $this->buyerCashtag;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
