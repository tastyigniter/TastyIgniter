<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a request to refund a payment using [RefundPayment]($e/Refunds/RefundPayment).
 */
class RefundPaymentRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var Money|null
     */
    private $appFeeMoney;

    /**
     * @var array
     */
    private $paymentId = [];

    /**
     * @var array
     */
    private $destinationId = [];

    /**
     * @var array
     */
    private $unlinked = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var array
     */
    private $reason = [];

    /**
     * @var array
     */
    private $paymentVersionToken = [];

    /**
     * @var array
     */
    private $teamMemberId = [];

    /**
     * @param string $idempotencyKey
     * @param Money $amountMoney
     */
    public function __construct(string $idempotencyKey, Money $amountMoney)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `RefundPayment` request. The key can be any valid string
     * but must be unique for every `RefundPayment` request.
     *
     * Keys are limited to a max of 45 characters - however, the number of allowed characters might be
     * less than 45, if multi-byte characters are used.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `RefundPayment` request. The key can be any valid string
     * but must be unique for every `RefundPayment` request.
     *
     * Keys are limited to a max of 45 characters - however, the number of allowed characters might be
     * less than 45, if multi-byte characters are used.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
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
     * Returns App Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppFeeMoney(): ?Money
    {
        return $this->appFeeMoney;
    }

    /**
     * Sets App Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps app_fee_money
     */
    public function setAppFeeMoney(?Money $appFeeMoney): void
    {
        $this->appFeeMoney = $appFeeMoney;
    }

    /**
     * Returns Payment Id.
     * The unique ID of the payment being refunded.
     * Required when unlinked=false, otherwise must not be set.
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
     * The unique ID of the payment being refunded.
     * Required when unlinked=false, otherwise must not be set.
     *
     * @maps payment_id
     */
    public function setPaymentId(?string $paymentId): void
    {
        $this->paymentId['value'] = $paymentId;
    }

    /**
     * Unsets Payment Id.
     * The unique ID of the payment being refunded.
     * Required when unlinked=false, otherwise must not be set.
     */
    public function unsetPaymentId(): void
    {
        $this->paymentId = [];
    }

    /**
     * Returns Destination Id.
     * The ID indicating where funds will be refunded to, if this is an unlinked refund.
     * This can be any of the following: A token generated by Web Payments SDK;
     * a card-on-file identifier.
     * Required for requests specifying unlinked=true.
     * Otherwise, if included when `unlinked=false`, will throw an error.
     */
    public function getDestinationId(): ?string
    {
        if (count($this->destinationId) == 0) {
            return null;
        }
        return $this->destinationId['value'];
    }

    /**
     * Sets Destination Id.
     * The ID indicating where funds will be refunded to, if this is an unlinked refund.
     * This can be any of the following: A token generated by Web Payments SDK;
     * a card-on-file identifier.
     * Required for requests specifying unlinked=true.
     * Otherwise, if included when `unlinked=false`, will throw an error.
     *
     * @maps destination_id
     */
    public function setDestinationId(?string $destinationId): void
    {
        $this->destinationId['value'] = $destinationId;
    }

    /**
     * Unsets Destination Id.
     * The ID indicating where funds will be refunded to, if this is an unlinked refund.
     * This can be any of the following: A token generated by Web Payments SDK;
     * a card-on-file identifier.
     * Required for requests specifying unlinked=true.
     * Otherwise, if included when `unlinked=false`, will throw an error.
     */
    public function unsetDestinationId(): void
    {
        $this->destinationId = [];
    }

    /**
     * Returns Unlinked.
     * Indicates that the refund is not linked to a Square payment.
     * If set to true, `destination_id` and `location_id` must be supplied while `payment_id` must not
     * be provided.
     */
    public function getUnlinked(): ?bool
    {
        if (count($this->unlinked) == 0) {
            return null;
        }
        return $this->unlinked['value'];
    }

    /**
     * Sets Unlinked.
     * Indicates that the refund is not linked to a Square payment.
     * If set to true, `destination_id` and `location_id` must be supplied while `payment_id` must not
     * be provided.
     *
     * @maps unlinked
     */
    public function setUnlinked(?bool $unlinked): void
    {
        $this->unlinked['value'] = $unlinked;
    }

    /**
     * Unsets Unlinked.
     * Indicates that the refund is not linked to a Square payment.
     * If set to true, `destination_id` and `location_id` must be supplied while `payment_id` must not
     * be provided.
     */
    public function unsetUnlinked(): void
    {
        $this->unlinked = [];
    }

    /**
     * Returns Location Id.
     * The location ID associated with the unlinked refund.
     * Required for requests specifying `unlinked=true`.
     * Otherwise, if included when `unlinked=false`, will throw an error.
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
     * The location ID associated with the unlinked refund.
     * Required for requests specifying `unlinked=true`.
     * Otherwise, if included when `unlinked=false`, will throw an error.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The location ID associated with the unlinked refund.
     * Required for requests specifying `unlinked=true`.
     * Otherwise, if included when `unlinked=false`, will throw an error.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Customer Id.
     * The [Customer](entity:Customer) ID of the customer associated with the refund.
     * This is required if the `destination_id` refers to a card on file created using the Cards
     * API. Only allowed when `unlinked=true`.
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
     * The [Customer](entity:Customer) ID of the customer associated with the refund.
     * This is required if the `destination_id` refers to a card on file created using the Cards
     * API. Only allowed when `unlinked=true`.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * The [Customer](entity:Customer) ID of the customer associated with the refund.
     * This is required if the `destination_id` refers to a card on file created using the Cards
     * API. Only allowed when `unlinked=true`.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Reason.
     * A description of the reason for the refund.
     */
    public function getReason(): ?string
    {
        if (count($this->reason) == 0) {
            return null;
        }
        return $this->reason['value'];
    }

    /**
     * Sets Reason.
     * A description of the reason for the refund.
     *
     * @maps reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason['value'] = $reason;
    }

    /**
     * Unsets Reason.
     * A description of the reason for the refund.
     */
    public function unsetReason(): void
    {
        $this->reason = [];
    }

    /**
     * Returns Payment Version Token.
     * Used for optimistic concurrency. This opaque token identifies the current `Payment`
     * version that the caller expects. If the server has a different version of the Payment,
     * the update fails and a response with a VERSION_MISMATCH error is returned.
     * If the versions match, or the field is not provided, the refund proceeds as normal.
     */
    public function getPaymentVersionToken(): ?string
    {
        if (count($this->paymentVersionToken) == 0) {
            return null;
        }
        return $this->paymentVersionToken['value'];
    }

    /**
     * Sets Payment Version Token.
     * Used for optimistic concurrency. This opaque token identifies the current `Payment`
     * version that the caller expects. If the server has a different version of the Payment,
     * the update fails and a response with a VERSION_MISMATCH error is returned.
     * If the versions match, or the field is not provided, the refund proceeds as normal.
     *
     * @maps payment_version_token
     */
    public function setPaymentVersionToken(?string $paymentVersionToken): void
    {
        $this->paymentVersionToken['value'] = $paymentVersionToken;
    }

    /**
     * Unsets Payment Version Token.
     * Used for optimistic concurrency. This opaque token identifies the current `Payment`
     * version that the caller expects. If the server has a different version of the Payment,
     * the update fails and a response with a VERSION_MISMATCH error is returned.
     * If the versions match, or the field is not provided, the refund proceeds as normal.
     */
    public function unsetPaymentVersionToken(): void
    {
        $this->paymentVersionToken = [];
    }

    /**
     * Returns Team Member Id.
     * An optional [TeamMember](entity:TeamMember) ID to associate with this refund.
     */
    public function getTeamMemberId(): ?string
    {
        if (count($this->teamMemberId) == 0) {
            return null;
        }
        return $this->teamMemberId['value'];
    }

    /**
     * Sets Team Member Id.
     * An optional [TeamMember](entity:TeamMember) ID to associate with this refund.
     *
     * @maps team_member_id
     */
    public function setTeamMemberId(?string $teamMemberId): void
    {
        $this->teamMemberId['value'] = $teamMemberId;
    }

    /**
     * Unsets Team Member Id.
     * An optional [TeamMember](entity:TeamMember) ID to associate with this refund.
     */
    public function unsetTeamMemberId(): void
    {
        $this->teamMemberId = [];
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
        $json['idempotency_key']           = $this->idempotencyKey;
        $json['amount_money']              = $this->amountMoney;
        if (isset($this->appFeeMoney)) {
            $json['app_fee_money']         = $this->appFeeMoney;
        }
        if (!empty($this->paymentId)) {
            $json['payment_id']            = $this->paymentId['value'];
        }
        if (!empty($this->destinationId)) {
            $json['destination_id']        = $this->destinationId['value'];
        }
        if (!empty($this->unlinked)) {
            $json['unlinked']              = $this->unlinked['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']           = $this->locationId['value'];
        }
        if (!empty($this->customerId)) {
            $json['customer_id']           = $this->customerId['value'];
        }
        if (!empty($this->reason)) {
            $json['reason']                = $this->reason['value'];
        }
        if (!empty($this->paymentVersionToken)) {
            $json['payment_version_token'] = $this->paymentVersionToken['value'];
        }
        if (!empty($this->teamMemberId)) {
            $json['team_member_id']        = $this->teamMemberId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
