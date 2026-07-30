<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class V1Money implements \JsonSerializable
{
    /**
     * @var array
     */
    private $amount = [];

    /**
     * @var string|null
     */
    private $currencyCode;

    /**
     * Returns Amount.
     * Amount in the lowest denominated value of this Currency. E.g. in USD
     * these are cents, in JPY they are Yen (which do not have a 'cent' concept).
     */
    public function getAmount(): ?int
    {
        if (count($this->amount) == 0) {
            return null;
        }
        return $this->amount['value'];
    }

    /**
     * Sets Amount.
     * Amount in the lowest denominated value of this Currency. E.g. in USD
     * these are cents, in JPY they are Yen (which do not have a 'cent' concept).
     *
     * @maps amount
     */
    public function setAmount(?int $amount): void
    {
        $this->amount['value'] = $amount;
    }

    /**
     * Unsets Amount.
     * Amount in the lowest denominated value of this Currency. E.g. in USD
     * these are cents, in JPY they are Yen (which do not have a 'cent' concept).
     */
    public function unsetAmount(): void
    {
        $this->amount = [];
    }

    /**
     * Returns Currency Code.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    /**
     * Sets Currency Code.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     *
     * @maps currency_code
     */
    public function setCurrencyCode(?string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
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
        if (!empty($this->amount)) {
            $json['amount']        = $this->amount['value'];
        }
        if (isset($this->currencyCode)) {
            $json['currency_code'] = $this->currencyCode;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
