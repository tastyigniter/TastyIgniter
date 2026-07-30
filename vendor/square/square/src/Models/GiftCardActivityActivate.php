<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents details about an `ACTIVATE` [gift card activity type]($m/GiftCardActivityType).
 */
class GiftCardActivityActivate implements \JsonSerializable
{
    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $orderId = [];

    /**
     * @var array
     */
    private $lineItemUid = [];

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var array
     */
    private $buyerPaymentInstrumentIds = [];

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
     * Returns Order Id.
     * The ID of the [order](entity:Order) that contains the `GIFT_CARD` line item.
     *
     * Applications that use the Square Orders API to process orders must specify the order ID
     * [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
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
     * The ID of the [order](entity:Order) that contains the `GIFT_CARD` line item.
     *
     * Applications that use the Square Orders API to process orders must specify the order ID
     * [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The ID of the [order](entity:Order) that contains the `GIFT_CARD` line item.
     *
     * Applications that use the Square Orders API to process orders must specify the order ID
     * [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
    }

    /**
     * Returns Line Item Uid.
     * The UID of the `GIFT_CARD` line item in the order that represents the gift card purchase.
     *
     * Applications that use the Square Orders API to process orders must specify the line item UID
     * in the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     */
    public function getLineItemUid(): ?string
    {
        if (count($this->lineItemUid) == 0) {
            return null;
        }
        return $this->lineItemUid['value'];
    }

    /**
     * Sets Line Item Uid.
     * The UID of the `GIFT_CARD` line item in the order that represents the gift card purchase.
     *
     * Applications that use the Square Orders API to process orders must specify the line item UID
     * in the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     *
     * @maps line_item_uid
     */
    public function setLineItemUid(?string $lineItemUid): void
    {
        $this->lineItemUid['value'] = $lineItemUid;
    }

    /**
     * Unsets Line Item Uid.
     * The UID of the `GIFT_CARD` line item in the order that represents the gift card purchase.
     *
     * Applications that use the Square Orders API to process orders must specify the line item UID
     * in the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     */
    public function unsetLineItemUid(): void
    {
        $this->lineItemUid = [];
    }

    /**
     * Returns Reference Id.
     * A client-specified ID that associates the gift card activity with an entity in another system.
     *
     * Applications that use a custom order processing system can use this field to track information
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
     * Applications that use a custom order processing system can use this field to track information
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
     * Applications that use a custom order processing system can use this field to track information
     * related to an order or payment.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Buyer Payment Instrument Ids.
     * The payment instrument IDs used to process the gift card purchase, such as a credit card ID
     * or bank account ID.
     *
     * Applications that use a custom order processing system must specify payment instrument IDs in
     * the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     * Square uses this information to perform compliance checks.
     *
     * For applications that use the Square Orders API to process payments, Square has the necessary
     * instrument IDs to perform compliance checks.
     *
     * @return string[]|null
     */
    public function getBuyerPaymentInstrumentIds(): ?array
    {
        if (count($this->buyerPaymentInstrumentIds) == 0) {
            return null;
        }
        return $this->buyerPaymentInstrumentIds['value'];
    }

    /**
     * Sets Buyer Payment Instrument Ids.
     * The payment instrument IDs used to process the gift card purchase, such as a credit card ID
     * or bank account ID.
     *
     * Applications that use a custom order processing system must specify payment instrument IDs in
     * the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     * Square uses this information to perform compliance checks.
     *
     * For applications that use the Square Orders API to process payments, Square has the necessary
     * instrument IDs to perform compliance checks.
     *
     * @maps buyer_payment_instrument_ids
     *
     * @param string[]|null $buyerPaymentInstrumentIds
     */
    public function setBuyerPaymentInstrumentIds(?array $buyerPaymentInstrumentIds): void
    {
        $this->buyerPaymentInstrumentIds['value'] = $buyerPaymentInstrumentIds;
    }

    /**
     * Unsets Buyer Payment Instrument Ids.
     * The payment instrument IDs used to process the gift card purchase, such as a credit card ID
     * or bank account ID.
     *
     * Applications that use a custom order processing system must specify payment instrument IDs in
     * the [CreateGiftCardActivity](api-endpoint:GiftCardActivities-CreateGiftCardActivity) request.
     * Square uses this information to perform compliance checks.
     *
     * For applications that use the Square Orders API to process payments, Square has the necessary
     * instrument IDs to perform compliance checks.
     */
    public function unsetBuyerPaymentInstrumentIds(): void
    {
        $this->buyerPaymentInstrumentIds = [];
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
            $json['amount_money']                 = $this->amountMoney;
        }
        if (!empty($this->orderId)) {
            $json['order_id']                     = $this->orderId['value'];
        }
        if (!empty($this->lineItemUid)) {
            $json['line_item_uid']                = $this->lineItemUid['value'];
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']                 = $this->referenceId['value'];
        }
        if (!empty($this->buyerPaymentInstrumentIds)) {
            $json['buyer_payment_instrument_ids'] = $this->buyerPaymentInstrumentIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
