<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The payment methods that customers can use to pay an [invoice]($m/Invoice) on the Square-hosted
 * invoice payment page.
 */
class InvoiceAcceptedPaymentMethods implements \JsonSerializable
{
    /**
     * @var array
     */
    private $card = [];

    /**
     * @var array
     */
    private $squareGiftCard = [];

    /**
     * @var array
     */
    private $bankAccount = [];

    /**
     * @var array
     */
    private $buyNowPayLater = [];

    /**
     * Returns Card.
     * Indicates whether credit card or debit card payments are accepted. The default value is `false`.
     */
    public function getCard(): ?bool
    {
        if (count($this->card) == 0) {
            return null;
        }
        return $this->card['value'];
    }

    /**
     * Sets Card.
     * Indicates whether credit card or debit card payments are accepted. The default value is `false`.
     *
     * @maps card
     */
    public function setCard(?bool $card): void
    {
        $this->card['value'] = $card;
    }

    /**
     * Unsets Card.
     * Indicates whether credit card or debit card payments are accepted. The default value is `false`.
     */
    public function unsetCard(): void
    {
        $this->card = [];
    }

    /**
     * Returns Square Gift Card.
     * Indicates whether Square gift card payments are accepted. The default value is `false`.
     */
    public function getSquareGiftCard(): ?bool
    {
        if (count($this->squareGiftCard) == 0) {
            return null;
        }
        return $this->squareGiftCard['value'];
    }

    /**
     * Sets Square Gift Card.
     * Indicates whether Square gift card payments are accepted. The default value is `false`.
     *
     * @maps square_gift_card
     */
    public function setSquareGiftCard(?bool $squareGiftCard): void
    {
        $this->squareGiftCard['value'] = $squareGiftCard;
    }

    /**
     * Unsets Square Gift Card.
     * Indicates whether Square gift card payments are accepted. The default value is `false`.
     */
    public function unsetSquareGiftCard(): void
    {
        $this->squareGiftCard = [];
    }

    /**
     * Returns Bank Account.
     * Indicates whether bank transfer payments are accepted. The default value is `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     */
    public function getBankAccount(): ?bool
    {
        if (count($this->bankAccount) == 0) {
            return null;
        }
        return $this->bankAccount['value'];
    }

    /**
     * Sets Bank Account.
     * Indicates whether bank transfer payments are accepted. The default value is `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     *
     * @maps bank_account
     */
    public function setBankAccount(?bool $bankAccount): void
    {
        $this->bankAccount['value'] = $bankAccount;
    }

    /**
     * Unsets Bank Account.
     * Indicates whether bank transfer payments are accepted. The default value is `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     */
    public function unsetBankAccount(): void
    {
        $this->bankAccount = [];
    }

    /**
     * Returns Buy Now Pay Later.
     * Indicates whether Afterpay (also known as Clearpay) payments are accepted. The default value is
     * `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     * This payment method is
     * supported if the seller account accepts Afterpay payments and the seller location is in a country
     * where Afterpay
     * invoice payments are supported. As a best practice, consider enabling an additional payment method
     * when allowing
     * `buy_now_pay_later` payments. For more information, including detailed requirements and processing
     * limits, see
     * [Buy Now Pay Later payments with Afterpay](https://developer.squareup.com/docs/invoices-
     * api/overview#buy-now-pay-later).
     */
    public function getBuyNowPayLater(): ?bool
    {
        if (count($this->buyNowPayLater) == 0) {
            return null;
        }
        return $this->buyNowPayLater['value'];
    }

    /**
     * Sets Buy Now Pay Later.
     * Indicates whether Afterpay (also known as Clearpay) payments are accepted. The default value is
     * `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     * This payment method is
     * supported if the seller account accepts Afterpay payments and the seller location is in a country
     * where Afterpay
     * invoice payments are supported. As a best practice, consider enabling an additional payment method
     * when allowing
     * `buy_now_pay_later` payments. For more information, including detailed requirements and processing
     * limits, see
     * [Buy Now Pay Later payments with Afterpay](https://developer.squareup.com/docs/invoices-
     * api/overview#buy-now-pay-later).
     *
     * @maps buy_now_pay_later
     */
    public function setBuyNowPayLater(?bool $buyNowPayLater): void
    {
        $this->buyNowPayLater['value'] = $buyNowPayLater;
    }

    /**
     * Unsets Buy Now Pay Later.
     * Indicates whether Afterpay (also known as Clearpay) payments are accepted. The default value is
     * `false`.
     *
     * This option is allowed only for invoices that have a single payment request of the `BALANCE` type.
     * This payment method is
     * supported if the seller account accepts Afterpay payments and the seller location is in a country
     * where Afterpay
     * invoice payments are supported. As a best practice, consider enabling an additional payment method
     * when allowing
     * `buy_now_pay_later` payments. For more information, including detailed requirements and processing
     * limits, see
     * [Buy Now Pay Later payments with Afterpay](https://developer.squareup.com/docs/invoices-
     * api/overview#buy-now-pay-later).
     */
    public function unsetBuyNowPayLater(): void
    {
        $this->buyNowPayLater = [];
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
        if (!empty($this->card)) {
            $json['card']              = $this->card['value'];
        }
        if (!empty($this->squareGiftCard)) {
            $json['square_gift_card']  = $this->squareGiftCard['value'];
        }
        if (!empty($this->bankAccount)) {
            $json['bank_account']      = $this->bankAccount['value'];
        }
        if (!empty($this->buyNowPayLater)) {
            $json['buy_now_pay_later'] = $this->buyNowPayLater['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
