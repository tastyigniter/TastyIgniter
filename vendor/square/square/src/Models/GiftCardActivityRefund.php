<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about a `REFUND` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityRefund implements \JsonSerializable
{
    /**
     * @var array
     */
    private $redeemActivityId = [];

    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var string|null
     */
    private $paymentId;

    /**
     * Returns Redeem Activity Id.
     * The ID of the refunded `REDEEM` gift card activity. Square populates this field if the
     * `payment_id` in the corresponding [RefundPayment](api-endpoint:Refunds-RefundPayment) request
     * represents a redemption made by the same gift card. Note that you must use `RefundPayment`
     * to refund a gift card payment to the same gift card if the payment was processed by Square.
     *
     * For applications that use a custom payment processing system, this field is required when creating
     * a `REFUND` activity. The provided `REDEEM` activity ID must be linked to the same gift card.
     */
    public function getRedeemActivityId(): ?string
    {
        if (count($this->redeemActivityId) == 0) {
            return null;
        }
        return $this->redeemActivityId['value'];
    }

    /**
     * Sets Redeem Activity Id.
     * The ID of the refunded `REDEEM` gift card activity. Square populates this field if the
     * `payment_id` in the corresponding [RefundPayment](api-endpoint:Refunds-RefundPayment) request
     * represents a redemption made by the same gift card. Note that you must use `RefundPayment`
     * to refund a gift card payment to the same gift card if the payment was processed by Square.
     *
     * For applications that use a custom payment processing system, this field is required when creating
     * a `REFUND` activity. The provided `REDEEM` activity ID must be linked to the same gift card.
     *
     * @maps redeem_activity_id
     */
    public function setRedeemActivityId(?string $redeemActivityId): void
    {
        $this->redeemActivityId['value'] = $redeemActivityId;
    }

    /**
     * Unsets Redeem Activity Id.
     * The ID of the refunded `REDEEM` gift card activity. Square populates this field if the
     * `payment_id` in the corresponding [RefundPayment](api-endpoint:Refunds-RefundPayment) request
     * represents a redemption made by the same gift card. Note that you must use `RefundPayment`
     * to refund a gift card payment to the same gift card if the payment was processed by Square.
     *
     * For applications that use a custom payment processing system, this field is required when creating
     * a `REFUND` activity. The provided `REDEEM` activity ID must be linked to the same gift card.
     */
    public function unsetRedeemActivityId(): void
    {
        $this->redeemActivityId = [];
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
     * Returns Reference Id.
     * A client-specified ID that associates the gift card activity with an entity in another system.
     */
    public function getReferenceId(): ?string
    {
        if (count($this->referenceId) == 0) {
            return null;
        }
        return $this->referenceId['value'];
    }

    /**
     * Sets Reference Id.
     * A client-specified ID that associates the gift card activity with an entity in another system.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId['value'] = $referenceId;
    }

    /**
     * Unsets Reference Id.
     * A client-specified ID that associates the gift card activity with an entity in another system.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Payment Id.
     * The ID of the refunded payment. Square populates this field if the refund is for a
     * payment processed by Square and one of the following conditions is true:
     *
     * - The Refunds API is used to refund a gift card payment to the same gift card.
     * - A seller initiated the refund from Square Point of Sale or the Seller Dashboard. The payment
     * source can be the
     * same gift card or a cross-tender payment from a credit card or a different gift card.
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     * The ID of the refunded payment. Square populates this field if the refund is for a
     * payment processed by Square and one of the following conditions is true:
     *
     * - The Refunds API is used to refund a gift card payment to the same gift card.
     * - A seller initiated the refund from Square Point of Sale or the Seller Dashboard. The payment
     * source can be the
     * same gift card or a cross-tender payment from a credit card or a different gift card.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId = $paymentId;
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
        if (!empty($this->redeemActivityId)) {
            $json['redeem_activity_id'] = $this->redeemActivityId['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']       = $this->amountMoney;
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']       = $this->referenceId['value'];
        }
        if (isset($this->paymentId)) {
            $json['payment_id']         = $this->paymentId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
