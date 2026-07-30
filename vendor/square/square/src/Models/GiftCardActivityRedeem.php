<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about a `REDEEM` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityRedeem implements \JsonSerializable
{
    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var string|null
     */
    private $paymentId;

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @param Money $amountMoney
     */
    public function __construct(Money $amountMoney)
    {
        $this->amountMoney = $amountMoney;
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
     * Returns Payment Id.
     * The ID of the payment that represents the gift card redemption. Square populates this field
     * if the payment was processed by Square.
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     * The ID of the payment that represents the gift card redemption. Square populates this field
     * if the payment was processed by Square.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Returns Reference Id.
     * A client-specified ID that associates the gift card activity with an entity in another system.
     *
     * Applications that use a custom payment processing system can use this field to track information
     * related to an order or payment.
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
     * Applications that use a custom payment processing system can use this field to track information
     * related to an order or payment.
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
     *
     * Applications that use a custom payment processing system can use this field to track information
     * related to an order or payment.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Status.
     * Indicates the status of a [gift card]($m/GiftCard) redemption. This status is relevant only for
     * redemptions made from Square products (such as Square Point of Sale) because Square products use a
     * two-state process. Gift cards redeemed using the Gift Card Activities API always have a `COMPLETED`
     * status.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Indicates the status of a [gift card]($m/GiftCard) redemption. This status is relevant only for
     * redemptions made from Square products (such as Square Point of Sale) because Square products use a
     * two-state process. Gift cards redeemed using the Gift Card Activities API always have a `COMPLETED`
     * status.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
        $json['amount_money']     = $this->amountMoney;
        if (isset($this->paymentId)) {
            $json['payment_id']   = $this->paymentId;
        }
        if (!empty($this->referenceId)) {
            $json['reference_id'] = $this->referenceId['value'];
        }
        if (isset($this->status)) {
            $json['status']       = $this->status;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
