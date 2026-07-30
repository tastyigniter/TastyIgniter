<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about an `ADJUST_DECREMENT` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityAdjustDecrement implements \JsonSerializable
{
    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var string
     */
    private $reason;

    /**
     * @param Money $amountMoney
     * @param string $reason
     */
    public function __construct(Money $amountMoney, string $reason)
    {
        $this->amountMoney = $amountMoney;
        $this->reason = $reason;
    }

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
    public function getAmountMoney(): Money
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
     * @required
     * @maps amount_money
     */
    public function setAmountMoney(Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Reason.
     * Indicates the reason for deducting money from a [gift card]($m/GiftCard).
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     * Indicates the reason for deducting money from a [gift card]($m/GiftCard).
     *
     * @required
     * @maps reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
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
        $json['amount_money'] = $this->amountMoney;
        $json['reason']       = $this->reason;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
