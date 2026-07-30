<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about an `UNLINKED_ACTIVITY_REFUND` [gift card activity
 * type]($m/GiftCardActivityType).
 */
class GiftCardActivityUnlinkedActivityRefund implements \JsonSerializable
{
    /**
     * @var Money
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
     * The ID of the refunded payment. This field is not used starting in Square version 2022-06-16.
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     * The ID of the refunded payment. This field is not used starting in Square version 2022-06-16.
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
        $json['amount_money']     = $this->amountMoney;
        if (!empty($this->referenceId)) {
            $json['reference_id'] = $this->referenceId['value'];
        }
        if (isset($this->paymentId)) {
            $json['payment_id']   = $this->paymentId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
