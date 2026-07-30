<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1Order
 */
class V1Order implements \JsonSerializable
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $buyerEmail = [];

    /**
     * @var array
     */
    private $recipientName = [];

    /**
     * @var array
     */
    private $recipientPhoneNumber = [];

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var Address|null
     */
    private $shippingAddress;

    /**
     * @var V1Money|null
     */
    private $subtotalMoney;

    /**
     * @var V1Money|null
     */
    private $totalShippingMoney;

    /**
     * @var V1Money|null
     */
    private $totalTaxMoney;

    /**
     * @var V1Money|null
     */
    private $totalPriceMoney;

    /**
     * @var V1Money|null
     */
    private $totalDiscountMoney;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $expiresAt = [];

    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $buyerNote = [];

    /**
     * @var array
     */
    private $completedNote = [];

    /**
     * @var array
     */
    private $refundedNote = [];

    /**
     * @var array
     */
    private $canceledNote = [];

    /**
     * @var V1Tender|null
     */
    private $tender;

    /**
     * @var array
     */
    private $orderHistory = [];

    /**
     * @var array
     */
    private $promoCode = [];

    /**
     * @var array
     */
    private $btcReceiveAddress = [];

    /**
     * @var array
     */
    private $btcPriceSatoshi = [];

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        if (count($this->errors) == 0) {
            return null;
        }
        return $this->errors['value'];
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors['value'] = $errors;
    }

    /**
     * Unsets Errors.
     * Any errors that occurred during the request.
     */
    public function unsetErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Returns Id.
     * The order's unique identifier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The order's unique identifier.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Buyer Email.
     * The email address of the order's buyer.
     */
    public function getBuyerEmail(): ?string
    {
        if (count($this->buyerEmail) == 0) {
            return null;
        }
        return $this->buyerEmail['value'];
    }

    /**
     * Sets Buyer Email.
     * The email address of the order's buyer.
     *
     * @maps buyer_email
     */
    public function setBuyerEmail(?string $buyerEmail): void
    {
        $this->buyerEmail['value'] = $buyerEmail;
    }

    /**
     * Unsets Buyer Email.
     * The email address of the order's buyer.
     */
    public function unsetBuyerEmail(): void
    {
        $this->buyerEmail = [];
    }

    /**
     * Returns Recipient Name.
     * The name of the order's buyer.
     */
    public function getRecipientName(): ?string
    {
        if (count($this->recipientName) == 0) {
            return null;
        }
        return $this->recipientName['value'];
    }

    /**
     * Sets Recipient Name.
     * The name of the order's buyer.
     *
     * @maps recipient_name
     */
    public function setRecipientName(?string $recipientName): void
    {
        $this->recipientName['value'] = $recipientName;
    }

    /**
     * Unsets Recipient Name.
     * The name of the order's buyer.
     */
    public function unsetRecipientName(): void
    {
        $this->recipientName = [];
    }

    /**
     * Returns Recipient Phone Number.
     * The phone number to use for the order's delivery.
     */
    public function getRecipientPhoneNumber(): ?string
    {
        if (count($this->recipientPhoneNumber) == 0) {
            return null;
        }
        return $this->recipientPhoneNumber['value'];
    }

    /**
     * Sets Recipient Phone Number.
     * The phone number to use for the order's delivery.
     *
     * @maps recipient_phone_number
     */
    public function setRecipientPhoneNumber(?string $recipientPhoneNumber): void
    {
        $this->recipientPhoneNumber['value'] = $recipientPhoneNumber;
    }

    /**
     * Unsets Recipient Phone Number.
     * The phone number to use for the order's delivery.
     */
    public function unsetRecipientPhoneNumber(): void
    {
        $this->recipientPhoneNumber = [];
    }

    /**
     * Returns State.
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets State.
     *
     * @maps state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * Returns Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getShippingAddress(): ?Address
    {
        return $this->shippingAddress;
    }

    /**
     * Sets Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps shipping_address
     */
    public function setShippingAddress(?Address $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Returns Subtotal Money.
     */
    public function getSubtotalMoney(): ?V1Money
    {
        return $this->subtotalMoney;
    }

    /**
     * Sets Subtotal Money.
     *
     * @maps subtotal_money
     */
    public function setSubtotalMoney(?V1Money $subtotalMoney): void
    {
        $this->subtotalMoney = $subtotalMoney;
    }

    /**
     * Returns Total Shipping Money.
     */
    public function getTotalShippingMoney(): ?V1Money
    {
        return $this->totalShippingMoney;
    }

    /**
     * Sets Total Shipping Money.
     *
     * @maps total_shipping_money
     */
    public function setTotalShippingMoney(?V1Money $totalShippingMoney): void
    {
        $this->totalShippingMoney = $totalShippingMoney;
    }

    /**
     * Returns Total Tax Money.
     */
    public function getTotalTaxMoney(): ?V1Money
    {
        return $this->totalTaxMoney;
    }

    /**
     * Sets Total Tax Money.
     *
     * @maps total_tax_money
     */
    public function setTotalTaxMoney(?V1Money $totalTaxMoney): void
    {
        $this->totalTaxMoney = $totalTaxMoney;
    }

    /**
     * Returns Total Price Money.
     */
    public function getTotalPriceMoney(): ?V1Money
    {
        return $this->totalPriceMoney;
    }

    /**
     * Sets Total Price Money.
     *
     * @maps total_price_money
     */
    public function setTotalPriceMoney(?V1Money $totalPriceMoney): void
    {
        $this->totalPriceMoney = $totalPriceMoney;
    }

    /**
     * Returns Total Discount Money.
     */
    public function getTotalDiscountMoney(): ?V1Money
    {
        return $this->totalDiscountMoney;
    }

    /**
     * Sets Total Discount Money.
     *
     * @maps total_discount_money
     */
    public function setTotalDiscountMoney(?V1Money $totalDiscountMoney): void
    {
        $this->totalDiscountMoney = $totalDiscountMoney;
    }

    /**
     * Returns Created At.
     * The time when the order was created, in ISO 8601 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The time when the order was created, in ISO 8601 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The time when the order was last modified, in ISO 8601 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The time when the order was last modified, in ISO 8601 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Expires At.
     * The time when the order expires if no action is taken, in ISO 8601 format.
     */
    public function getExpiresAt(): ?string
    {
        if (count($this->expiresAt) == 0) {
            return null;
        }
        return $this->expiresAt['value'];
    }

    /**
     * Sets Expires At.
     * The time when the order expires if no action is taken, in ISO 8601 format.
     *
     * @maps expires_at
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt['value'] = $expiresAt;
    }

    /**
     * Unsets Expires At.
     * The time when the order expires if no action is taken, in ISO 8601 format.
     */
    public function unsetExpiresAt(): void
    {
        $this->expiresAt = [];
    }

    /**
     * Returns Payment Id.
     * The unique identifier of the payment associated with the order.
     */
    public function getPaymentId(): ?string
    {
        if (count($this->paymentId) == 0) {
            return null;
        }
        return $this->paymentId['value'];
    }

    /**
     * Sets Payment Id.
     * The unique identifier of the payment associated with the order.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId['value'] = $paymentId;
    }

    /**
     * Unsets Payment Id.
     * The unique identifier of the payment associated with the order.
     */
    public function unsetPaymentId(): void
    {
        $this->paymentId = [];
    }

    /**
     * Returns Buyer Note.
     * A note provided by the buyer when the order was created, if any.
     */
    public function getBuyerNote(): ?string
    {
        if (count($this->buyerNote) == 0) {
            return null;
        }
        return $this->buyerNote['value'];
    }

    /**
     * Sets Buyer Note.
     * A note provided by the buyer when the order was created, if any.
     *
     * @maps buyer_note
     */
    public function setBuyerNote(?string $buyerNote): void
    {
        $this->buyerNote['value'] = $buyerNote;
    }

    /**
     * Unsets Buyer Note.
     * A note provided by the buyer when the order was created, if any.
     */
    public function unsetBuyerNote(): void
    {
        $this->buyerNote = [];
    }

    /**
     * Returns Completed Note.
     * A note provided by the merchant when the order's state was set to COMPLETED, if any
     */
    public function getCompletedNote(): ?string
    {
        if (count($this->completedNote) == 0) {
            return null;
        }
        return $this->completedNote['value'];
    }

    /**
     * Sets Completed Note.
     * A note provided by the merchant when the order's state was set to COMPLETED, if any
     *
     * @maps completed_note
     */
    public function setCompletedNote(?string $completedNote): void
    {
        $this->completedNote['value'] = $completedNote;
    }

    /**
     * Unsets Completed Note.
     * A note provided by the merchant when the order's state was set to COMPLETED, if any
     */
    public function unsetCompletedNote(): void
    {
        $this->completedNote = [];
    }

    /**
     * Returns Refunded Note.
     * A note provided by the merchant when the order's state was set to REFUNDED, if any.
     */
    public function getRefundedNote(): ?string
    {
        if (count($this->refundedNote) == 0) {
            return null;
        }
        return $this->refundedNote['value'];
    }

    /**
     * Sets Refunded Note.
     * A note provided by the merchant when the order's state was set to REFUNDED, if any.
     *
     * @maps refunded_note
     */
    public function setRefundedNote(?string $refundedNote): void
    {
        $this->refundedNote['value'] = $refundedNote;
    }

    /**
     * Unsets Refunded Note.
     * A note provided by the merchant when the order's state was set to REFUNDED, if any.
     */
    public function unsetRefundedNote(): void
    {
        $this->refundedNote = [];
    }

    /**
     * Returns Canceled Note.
     * A note provided by the merchant when the order's state was set to CANCELED, if any.
     */
    public function getCanceledNote(): ?string
    {
        if (count($this->canceledNote) == 0) {
            return null;
        }
        return $this->canceledNote['value'];
    }

    /**
     * Sets Canceled Note.
     * A note provided by the merchant when the order's state was set to CANCELED, if any.
     *
     * @maps canceled_note
     */
    public function setCanceledNote(?string $canceledNote): void
    {
        $this->canceledNote['value'] = $canceledNote;
    }

    /**
     * Unsets Canceled Note.
     * A note provided by the merchant when the order's state was set to CANCELED, if any.
     */
    public function unsetCanceledNote(): void
    {
        $this->canceledNote = [];
    }

    /**
     * Returns Tender.
     * A tender represents a discrete monetary exchange. Square represents this
     * exchange as a money object with a specific currency and amount, where the
     * amount is given in the smallest denomination of the given currency.
     *
     * Square POS can accept more than one form of tender for a single payment (such
     * as by splitting a bill between a credit card and a gift card). The `tender`
     * field of the Payment object lists all forms of tender used for the payment.
     *
     * Split tender payments behave slightly differently from single tender payments:
     *
     * The receipt_url for a split tender corresponds only to the first tender listed
     * in the tender field. To get the receipt URLs for the remaining tenders, use
     * the receipt_url fields of the corresponding Tender objects.
     *
     * *A note on gift cards**: when a customer purchases a Square gift card from a
     * merchant, the merchant receives the full amount of the gift card in the
     * associated payment.
     *
     * When that gift card is used as a tender, the balance of the gift card is
     * reduced and the merchant receives no funds. A `Tender` object with a type of
     * `SQUARE_GIFT_CARD` indicates a gift card was used for some or all of the
     * associated payment.
     */
    public function getTender(): ?V1Tender
    {
        return $this->tender;
    }

    /**
     * Sets Tender.
     * A tender represents a discrete monetary exchange. Square represents this
     * exchange as a money object with a specific currency and amount, where the
     * amount is given in the smallest denomination of the given currency.
     *
     * Square POS can accept more than one form of tender for a single payment (such
     * as by splitting a bill between a credit card and a gift card). The `tender`
     * field of the Payment object lists all forms of tender used for the payment.
     *
     * Split tender payments behave slightly differently from single tender payments:
     *
     * The receipt_url for a split tender corresponds only to the first tender listed
     * in the tender field. To get the receipt URLs for the remaining tenders, use
     * the receipt_url fields of the corresponding Tender objects.
     *
     * *A note on gift cards**: when a customer purchases a Square gift card from a
     * merchant, the merchant receives the full amount of the gift card in the
     * associated payment.
     *
     * When that gift card is used as a tender, the balance of the gift card is
     * reduced and the merchant receives no funds. A `Tender` object with a type of
     * `SQUARE_GIFT_CARD` indicates a gift card was used for some or all of the
     * associated payment.
     *
     * @maps tender
     */
    public function setTender(?V1Tender $tender): void
    {
        $this->tender = $tender;
    }

    /**
     * Returns Order History.
     * The history of actions associated with the order.
     *
     * @return V1OrderHistoryEntry[]|null
     */
    public function getOrderHistory(): ?array
    {
        if (count($this->orderHistory) == 0) {
            return null;
        }
        return $this->orderHistory['value'];
    }

    /**
     * Sets Order History.
     * The history of actions associated with the order.
     *
     * @maps order_history
     *
     * @param V1OrderHistoryEntry[]|null $orderHistory
     */
    public function setOrderHistory(?array $orderHistory): void
    {
        $this->orderHistory['value'] = $orderHistory;
    }

    /**
     * Unsets Order History.
     * The history of actions associated with the order.
     */
    public function unsetOrderHistory(): void
    {
        $this->orderHistory = [];
    }

    /**
     * Returns Promo Code.
     * The promo code provided by the buyer, if any.
     */
    public function getPromoCode(): ?string
    {
        if (count($this->promoCode) == 0) {
            return null;
        }
        return $this->promoCode['value'];
    }

    /**
     * Sets Promo Code.
     * The promo code provided by the buyer, if any.
     *
     * @maps promo_code
     */
    public function setPromoCode(?string $promoCode): void
    {
        $this->promoCode['value'] = $promoCode;
    }

    /**
     * Unsets Promo Code.
     * The promo code provided by the buyer, if any.
     */
    public function unsetPromoCode(): void
    {
        $this->promoCode = [];
    }

    /**
     * Returns Btc Receive Address.
     * For Bitcoin transactions, the address that the buyer sent Bitcoin to.
     */
    public function getBtcReceiveAddress(): ?string
    {
        if (count($this->btcReceiveAddress) == 0) {
            return null;
        }
        return $this->btcReceiveAddress['value'];
    }

    /**
     * Sets Btc Receive Address.
     * For Bitcoin transactions, the address that the buyer sent Bitcoin to.
     *
     * @maps btc_receive_address
     */
    public function setBtcReceiveAddress(?string $btcReceiveAddress): void
    {
        $this->btcReceiveAddress['value'] = $btcReceiveAddress;
    }

    /**
     * Unsets Btc Receive Address.
     * For Bitcoin transactions, the address that the buyer sent Bitcoin to.
     */
    public function unsetBtcReceiveAddress(): void
    {
        $this->btcReceiveAddress = [];
    }

    /**
     * Returns Btc Price Satoshi.
     * For Bitcoin transactions, the price of the buyer's order in satoshi (100 million satoshi equals 1
     * BTC).
     */
    public function getBtcPriceSatoshi(): ?float
    {
        if (count($this->btcPriceSatoshi) == 0) {
            return null;
        }
        return $this->btcPriceSatoshi['value'];
    }

    /**
     * Sets Btc Price Satoshi.
     * For Bitcoin transactions, the price of the buyer's order in satoshi (100 million satoshi equals 1
     * BTC).
     *
     * @maps btc_price_satoshi
     */
    public function setBtcPriceSatoshi(?float $btcPriceSatoshi): void
    {
        $this->btcPriceSatoshi['value'] = $btcPriceSatoshi;
    }

    /**
     * Unsets Btc Price Satoshi.
     * For Bitcoin transactions, the price of the buyer's order in satoshi (100 million satoshi equals 1
     * BTC).
     */
    public function unsetBtcPriceSatoshi(): void
    {
        $this->btcPriceSatoshi = [];
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
        if (!empty($this->errors)) {
            $json['errors']                 = $this->errors['value'];
        }
        if (isset($this->id)) {
            $json['id']                     = $this->id;
        }
        if (!empty($this->buyerEmail)) {
            $json['buyer_email']            = $this->buyerEmail['value'];
        }
        if (!empty($this->recipientName)) {
            $json['recipient_name']         = $this->recipientName['value'];
        }
        if (!empty($this->recipientPhoneNumber)) {
            $json['recipient_phone_number'] = $this->recipientPhoneNumber['value'];
        }
        if (isset($this->state)) {
            $json['state']                  = $this->state;
        }
        if (isset($this->shippingAddress)) {
            $json['shipping_address']       = $this->shippingAddress;
        }
        if (isset($this->subtotalMoney)) {
            $json['subtotal_money']         = $this->subtotalMoney;
        }
        if (isset($this->totalShippingMoney)) {
            $json['total_shipping_money']   = $this->totalShippingMoney;
        }
        if (isset($this->totalTaxMoney)) {
            $json['total_tax_money']        = $this->totalTaxMoney;
        }
        if (isset($this->totalPriceMoney)) {
            $json['total_price_money']      = $this->totalPriceMoney;
        }
        if (isset($this->totalDiscountMoney)) {
            $json['total_discount_money']   = $this->totalDiscountMoney;
        }
        if (isset($this->createdAt)) {
            $json['created_at']             = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']             = $this->updatedAt;
        }
        if (!empty($this->expiresAt)) {
            $json['expires_at']             = $this->expiresAt['value'];
        }
        if (!empty($this->paymentId)) {
            $json['payment_id']             = $this->paymentId['value'];
        }
        if (!empty($this->buyerNote)) {
            $json['buyer_note']             = $this->buyerNote['value'];
        }
        if (!empty($this->completedNote)) {
            $json['completed_note']         = $this->completedNote['value'];
        }
        if (!empty($this->refundedNote)) {
            $json['refunded_note']          = $this->refundedNote['value'];
        }
        if (!empty($this->canceledNote)) {
            $json['canceled_note']          = $this->canceledNote['value'];
        }
        if (isset($this->tender)) {
            $json['tender']                 = $this->tender;
        }
        if (!empty($this->orderHistory)) {
            $json['order_history']          = $this->orderHistory['value'];
        }
        if (!empty($this->promoCode)) {
            $json['promo_code']             = $this->promoCode['value'];
        }
        if (!empty($this->btcReceiveAddress)) {
            $json['btc_receive_address']    = $this->btcReceiveAddress['value'];
        }
        if (!empty($this->btcPriceSatoshi)) {
            $json['btc_price_satoshi']      = $this->btcPriceSatoshi['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
