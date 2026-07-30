<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about a `TRANSFER_BALANCE_TO` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityTransferBalanceTo implements \JsonSerializable
{
    /**
     * @var string
     */
    private $transferFromGiftCardId;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @param string $transferFromGiftCardId
     * @param Money $amountMoney
     */
    public function __construct(string $transferFromGiftCardId, Money $amountMoney)
    {
        $this->transferFromGiftCardId = $transferFromGiftCardId;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Transfer From Gift Card Id.
     * The ID of the gift card from which the specified amount was transferred.
     */
    public function getTransferFromGiftCardId(): string
    {
        return $this->transferFromGiftCardId;
    }

    /**
     * Sets Transfer From Gift Card Id.
     * The ID of the gift card from which the specified amount was transferred.
     *
     * @required
     * @maps transfer_from_gift_card_id
     */
    public function setTransferFromGiftCardId(string $transferFromGiftCardId): void
    {
        $this->transferFromGiftCardId = $transferFromGiftCardId;
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
        $json['transfer_from_gift_card_id'] = $this->transferFromGiftCardId;
        $json['amount_money']               = $this->amountMoney;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
