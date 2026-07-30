<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an amount of money. `Money` fields can be signed or unsigned.
 * Fields that do not explicitly define whether they are signed or unsigned are
 * considered unsigned and can only hold positive amounts. For signed fields, the
 * sign of the value indicates the purpose of the money transfer. See
 * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
 * monetary-amounts)
 * for more information.
 */
class Money implements \JsonSerializable
{
    /**
     * @var array
     */
    private $amount = [];

    /**
     * @var string|null
     */
    private $currency;

    /**
     * Returns Amount.
     * The amount of money, in the smallest denomination of the currency
     * indicated by `currency`. For example, when `currency` is `USD`, `amount` is
     * in cents. Monetary amounts can be positive or negative. See the specific
     * field description to determine the meaning of the sign in a particular case.
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
     * The amount of money, in the smallest denomination of the currency
     * indicated by `currency`. For example, when `currency` is `USD`, `amount` is
     * in cents. Monetary amounts can be positive or negative. See the specific
     * field description to determine the meaning of the sign in a particular case.
     *
     * @maps amount
     */
    public function setAmount(?int $amount): void
    {
        $this->amount['value'] = $amount;
    }

    /**
     * Unsets Amount.
     * The amount of money, in the smallest denomination of the currency
     * indicated by `currency`. For example, when `currency` is `USD`, `amount` is
     * in cents. Monetary amounts can be positive or negative. See the specific
     * field description to determine the meaning of the sign in a particular case.
     */
    public function unsetAmount(): void
    {
        $this->amount = [];
    }

    /**
     * Returns Currency.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Currency.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     *
     * @maps currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
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
            $json['amount']   = $this->amount['value'];
        }
        if (isset($this->currency)) {
            $json['currency'] = $this->currency;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
