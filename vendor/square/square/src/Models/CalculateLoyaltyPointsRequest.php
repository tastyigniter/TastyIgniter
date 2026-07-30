<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [CalculateLoyaltyPoints]($e/Loyalty/CalculateLoyaltyPoints) request.
 */
class CalculateLoyaltyPointsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $orderId = [];

    /**
     * @var Money|null
     */
    private $transactionAmountMoney;

    /**
     * @var array
     */
    private $loyaltyAccountId = [];

    /**
     * Returns Order Id.
     * The [order](entity:Order) ID for which to calculate the points.
     * Specify this field if your application uses the Orders API to process orders.
     * Otherwise, specify the `transaction_amount_money`.
     */
    public function getOrderId(): ?string
    {
        if (count($this->orderId) == 0) {
            return null;
        }
        return $this->orderId['value'];
    }

    /**
     * Sets Order Id.
     * The [order](entity:Order) ID for which to calculate the points.
     * Specify this field if your application uses the Orders API to process orders.
     * Otherwise, specify the `transaction_amount_money`.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The [order](entity:Order) ID for which to calculate the points.
     * Specify this field if your application uses the Orders API to process orders.
     * Otherwise, specify the `transaction_amount_money`.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
    }

    /**
     * Returns Transaction Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTransactionAmountMoney(): ?Money
    {
        return $this->transactionAmountMoney;
    }

    /**
     * Sets Transaction Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps transaction_amount_money
     */
    public function setTransactionAmountMoney(?Money $transactionAmountMoney): void
    {
        $this->transactionAmountMoney = $transactionAmountMoney;
    }

    /**
     * Returns Loyalty Account Id.
     * The ID of the target [loyalty account](entity:LoyaltyAccount). Optionally specify this field
     * if your application uses the Orders API to process orders.
     *
     * If specified, the `promotion_points` field in the response shows the number of points the buyer
     * would
     * earn from the purchase. In this case, Square uses the account ID to determine whether the
     * promotion's
     * `trigger_limit` (the maximum number of times that a buyer can trigger the promotion) has been
     * reached.
     * If not specified, the `promotion_points` field shows the number of points the purchase qualifies
     * for regardless of the trigger limit.
     */
    public function getLoyaltyAccountId(): ?string
    {
        if (count($this->loyaltyAccountId) == 0) {
            return null;
        }
        return $this->loyaltyAccountId['value'];
    }

    /**
     * Sets Loyalty Account Id.
     * The ID of the target [loyalty account](entity:LoyaltyAccount). Optionally specify this field
     * if your application uses the Orders API to process orders.
     *
     * If specified, the `promotion_points` field in the response shows the number of points the buyer
     * would
     * earn from the purchase. In this case, Square uses the account ID to determine whether the
     * promotion's
     * `trigger_limit` (the maximum number of times that a buyer can trigger the promotion) has been
     * reached.
     * If not specified, the `promotion_points` field shows the number of points the purchase qualifies
     * for regardless of the trigger limit.
     *
     * @maps loyalty_account_id
     */
    public function setLoyaltyAccountId(?string $loyaltyAccountId): void
    {
        $this->loyaltyAccountId['value'] = $loyaltyAccountId;
    }

    /**
     * Unsets Loyalty Account Id.
     * The ID of the target [loyalty account](entity:LoyaltyAccount). Optionally specify this field
     * if your application uses the Orders API to process orders.
     *
     * If specified, the `promotion_points` field in the response shows the number of points the buyer
     * would
     * earn from the purchase. In this case, Square uses the account ID to determine whether the
     * promotion's
     * `trigger_limit` (the maximum number of times that a buyer can trigger the promotion) has been
     * reached.
     * If not specified, the `promotion_points` field shows the number of points the purchase qualifies
     * for regardless of the trigger limit.
     */
    public function unsetLoyaltyAccountId(): void
    {
        $this->loyaltyAccountId = [];
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
        if (!empty($this->orderId)) {
            $json['order_id']                 = $this->orderId['value'];
        }
        if (isset($this->transactionAmountMoney)) {
            $json['transaction_amount_money'] = $this->transactionAmountMoney;
        }
        if (!empty($this->loyaltyAccountId)) {
            $json['loyalty_account_id']       = $this->loyaltyAccountId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
