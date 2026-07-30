<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a payout fee that can incur as part of a payout.
 */
class PayoutFee implements \JsonSerializable
{
    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $effectiveAt = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * Returns Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): ?Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps amount_money
     */
    public function setAmountMoney(?Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Effective At.
     * The timestamp of when the fee takes effect, in RFC 3339 format.
     */
    public function getEffectiveAt(): ?string
    {
        if (count($this->effectiveAt) == 0) {
            return null;
        }
        return $this->effectiveAt['value'];
    }

    /**
     * Sets Effective At.
     * The timestamp of when the fee takes effect, in RFC 3339 format.
     *
     * @maps effective_at
     */
    public function setEffectiveAt(?string $effectiveAt): void
    {
        $this->effectiveAt['value'] = $effectiveAt;
    }

    /**
     * Unsets Effective At.
     * The timestamp of when the fee takes effect, in RFC 3339 format.
     */
    public function unsetEffectiveAt(): void
    {
        $this->effectiveAt = [];
    }

    /**
     * Returns Type.
     * Represents the type of payout fee that can incur as part of a payout.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Represents the type of payout fee that can incur as part of a payout.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
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
        if (isset($this->amountMoney)) {
            $json['amount_money'] = $this->amountMoney;
        }
        if (!empty($this->effectiveAt)) {
            $json['effective_at'] = $this->effectiveAt['value'];
        }
        if (isset($this->type)) {
            $json['type']         = $this->type;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
