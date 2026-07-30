<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a refund processed for a Square transaction.
 */
class Refund implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @var array
     */
    private $transactionId = [];

    /**
     * @var string
     */
    private $tenderId;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var string
     */
    private $status;

    /**
     * @var Money|null
     */
    private $processingFeeMoney;

    /**
     * @var array
     */
    private $additionalRecipients = [];

    /**
     * @param string $id
     * @param string $locationId
     * @param string $tenderId
     * @param string $reason
     * @param Money $amountMoney
     * @param string $status
     */
    public function __construct(
        string $id,
        string $locationId,
        string $tenderId,
        string $reason,
        Money $amountMoney,
        string $status
    ) {
        $this->id = $id;
        $this->locationId = $locationId;
        $this->tenderId = $tenderId;
        $this->reason = $reason;
        $this->amountMoney = $amountMoney;
        $this->status = $status;
    }

    /**
     * Returns Id.
     * The refund's unique ID.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The refund's unique ID.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Location Id.
     * The ID of the refund's associated location.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the refund's associated location.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Transaction Id.
     * The ID of the transaction that the refunded tender is part of.
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
     * The ID of the transaction that the refunded tender is part of.
     *
     * @maps transaction_id
     */
    public function setTransactionId(?string $transactionId): void
    {
        $this->transactionId['value'] = $transactionId;
    }

    /**
     * Unsets Transaction Id.
     * The ID of the transaction that the refunded tender is part of.
     */
    public function unsetTransactionId(): void
    {
        $this->transactionId = [];
    }

    /**
     * Returns Tender Id.
     * The ID of the refunded tender.
     */
    public function getTenderId(): string
    {
        return $this->tenderId;
    }

    /**
     * Sets Tender Id.
     * The ID of the refunded tender.
     *
     * @required
     * @maps tender_id
     */
    public function setTenderId(string $tenderId): void
    {
        $this->tenderId = $tenderId;
    }

    /**
     * Returns Created At.
     * The timestamp for when the refund was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp for when the refund was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Reason.
     * The reason for the refund being issued.
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     * The reason for the refund being issued.
     *
     * @required
     * @maps reason
     */
    public function setReason(string $reason): void
    {
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
     * Returns Status.
     * Indicates a refund's current status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Indicates a refund's current status.
     *
     * @required
     * @maps status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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
     * Returns Additional Recipients.
     * Additional recipients (other than the merchant) receiving a portion of this refund.
     * For example, fees assessed on a refund of a purchase by a third party integration.
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
     * Additional recipients (other than the merchant) receiving a portion of this refund.
     * For example, fees assessed on a refund of a purchase by a third party integration.
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
     * Additional recipients (other than the merchant) receiving a portion of this refund.
     * For example, fees assessed on a refund of a purchase by a third party integration.
     */
    public function unsetAdditionalRecipients(): void
    {
        $this->additionalRecipients = [];
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
        $json['id']                        = $this->id;
        $json['location_id']               = $this->locationId;
        if (!empty($this->transactionId)) {
            $json['transaction_id']        = $this->transactionId['value'];
        }
        $json['tender_id']                 = $this->tenderId;
        if (isset($this->createdAt)) {
            $json['created_at']            = $this->createdAt;
        }
        $json['reason']                    = $this->reason;
        $json['amount_money']              = $this->amountMoney;
        $json['status']                    = $this->status;
        if (isset($this->processingFeeMoney)) {
            $json['processing_fee_money']  = $this->processingFeeMoney;
        }
        if (!empty($this->additionalRecipients)) {
            $json['additional_recipients'] = $this->additionalRecipients['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
