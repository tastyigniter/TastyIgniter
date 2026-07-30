<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a tender (i.e., a method of payment) used in a Square transaction.
 */
class Tender implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $transactionId = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var Money|null
     */
    private $tipMoney;

    /**
     * @var Money|null
     */
    private $processingFeeMoney;

    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var string
     */
    private $type;

    /**
     * @var TenderCardDetails|null
     */
    private $cardDetails;

    /**
     * @var TenderCashDetails|null
     */
    private $cashDetails;

    /**
     * @var array
     */
    private $additionalRecipients = [];

    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Returns Id.
     * The tender's unique ID. It is the associated payment ID.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The tender's unique ID. It is the associated payment ID.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Location Id.
     * The ID of the transaction's associated location.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the transaction's associated location.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the transaction's associated location.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Transaction Id.
     * The ID of the tender's associated transaction.
     */
    public function getTransactionId(): ?string
    {
        if (count($this->transactionId) == 0) {
            return null;
        }
        return $this->transactionId['value'];
    }

    /**
     * Sets Transaction Id.
     * The ID of the tender's associated transaction.
     *
     * @maps transaction_id
     */
    public function setTransactionId(?string $transactionId): void
    {
        $this->transactionId['value'] = $transactionId;
    }

    /**
     * Unsets Transaction Id.
     * The ID of the tender's associated transaction.
     */
    public function unsetTransactionId(): void
    {
        $this->transactionId = [];
    }

    /**
     * Returns Created At.
     * The timestamp for when the tender was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp for when the tender was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Note.
     * An optional note associated with the tender at the time of payment.
     */
    public function getNote(): ?string
    {
        if (count($this->note) == 0) {
            return null;
        }
        return $this->note['value'];
    }

    /**
     * Sets Note.
     * An optional note associated with the tender at the time of payment.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * An optional note associated with the tender at the time of payment.
     */
    public function unsetNote(): void
    {
        $this->note = [];
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
     * Returns Tip Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTipMoney(): ?Money
    {
        return $this->tipMoney;
    }

    /**
     * Sets Tip Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps tip_money
     */
    public function setTipMoney(?Money $tipMoney): void
    {
        $this->tipMoney = $tipMoney;
    }

    /**
     * Returns Processing Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getProcessingFeeMoney(): ?Money
    {
        return $this->processingFeeMoney;
    }

    /**
     * Sets Processing Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps processing_fee_money
     */
    public function setProcessingFeeMoney(?Money $processingFeeMoney): void
    {
        $this->processingFeeMoney = $processingFeeMoney;
    }

    /**
     * Returns Customer Id.
     * If the tender is associated with a customer or represents a customer's card on file,
     * this is the ID of the associated customer.
     */
    public function getCustomerId(): ?string
    {
        if (count($this->customerId) == 0) {
            return null;
        }
        return $this->customerId['value'];
    }

    /**
     * Sets Customer Id.
     * If the tender is associated with a customer or represents a customer's card on file,
     * this is the ID of the associated customer.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * If the tender is associated with a customer or represents a customer's card on file,
     * this is the ID of the associated customer.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Type.
     * Indicates a tender's type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Indicates a tender's type.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Card Details.
     * Represents additional details of a tender with `type` `CARD` or `SQUARE_GIFT_CARD`
     */
    public function getCardDetails(): ?TenderCardDetails
    {
        return $this->cardDetails;
    }

    /**
     * Sets Card Details.
     * Represents additional details of a tender with `type` `CARD` or `SQUARE_GIFT_CARD`
     *
     * @maps card_details
     */
    public function setCardDetails(?TenderCardDetails $cardDetails): void
    {
        $this->cardDetails = $cardDetails;
    }

    /**
     * Returns Cash Details.
     * Represents the details of a tender with `type` `CASH`.
     */
    public function getCashDetails(): ?TenderCashDetails
    {
        return $this->cashDetails;
    }

    /**
     * Sets Cash Details.
     * Represents the details of a tender with `type` `CASH`.
     *
     * @maps cash_details
     */
    public function setCashDetails(?TenderCashDetails $cashDetails): void
    {
        $this->cashDetails = $cashDetails;
    }

    /**
     * Returns Additional Recipients.
     * Additional recipients (other than the merchant) receiving a portion of this tender.
     * For example, fees assessed on the purchase by a third party integration.
     *
     * @return AdditionalRecipient[]|null
     */
    public function getAdditionalRecipients(): ?array
    {
        if (count($this->additionalRecipients) == 0) {
            return null;
        }
        return $this->additionalRecipients['value'];
    }

    /**
     * Sets Additional Recipients.
     * Additional recipients (other than the merchant) receiving a portion of this tender.
     * For example, fees assessed on the purchase by a third party integration.
     *
     * @maps additional_recipients
     *
     * @param AdditionalRecipient[]|null $additionalRecipients
     */
    public function setAdditionalRecipients(?array $additionalRecipients): void
    {
        $this->additionalRecipients['value'] = $additionalRecipients;
    }

    /**
     * Unsets Additional Recipients.
     * Additional recipients (other than the merchant) receiving a portion of this tender.
     * For example, fees assessed on the purchase by a third party integration.
     */
    public function unsetAdditionalRecipients(): void
    {
        $this->additionalRecipients = [];
    }

    /**
     * Returns Payment Id.
     * The ID of the [Payment](entity:Payment) that corresponds to this tender.
     * This value is only present for payments created with the v2 Payments API.
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
     * The ID of the [Payment](entity:Payment) that corresponds to this tender.
     * This value is only present for payments created with the v2 Payments API.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId['value'] = $paymentId;
    }

    /**
     * Unsets Payment Id.
     * The ID of the [Payment](entity:Payment) that corresponds to this tender.
     * This value is only present for payments created with the v2 Payments API.
     */
    public function unsetPaymentId(): void
    {
        $this->paymentId = [];
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
        if (isset($this->id)) {
            $json['id']                    = $this->id;
        }
        if (!empty($this->locationId)) {
            $json['location_id']           = $this->locationId['value'];
        }
        if (!empty($this->transactionId)) {
            $json['transaction_id']        = $this->transactionId['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']            = $this->createdAt;
        }
        if (!empty($this->note)) {
            $json['note']                  = $this->note['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']          = $this->amountMoney;
        }
        if (isset($this->tipMoney)) {
            $json['tip_money']             = $this->tipMoney;
        }
        if (isset($this->processingFeeMoney)) {
            $json['processing_fee_money']  = $this->processingFeeMoney;
        }
        if (!empty($this->customerId)) {
            $json['customer_id']           = $this->customerId['value'];
        }
        $json['type']                      = $this->type;
        if (isset($this->cardDetails)) {
            $json['card_details']          = $this->cardDetails;
        }
        if (isset($this->cashDetails)) {
            $json['cash_details']          = $this->cashDetails;
        }
        if (!empty($this->additionalRecipients)) {
            $json['additional_recipients'] = $this->additionalRecipients['value'];
        }
        if (!empty($this->paymentId)) {
            $json['payment_id']            = $this->paymentId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
