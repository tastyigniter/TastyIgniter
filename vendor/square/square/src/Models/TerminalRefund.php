<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit
 * network) payment refunds.
 */
class TerminalRefund implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $refundId;

    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var array
     */
    private $deadlineDuration = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $cancelReason;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var string|null
     */
    private $appId;

    /**
     * @var string|null
     */
    private $locationId;

    /**
     * @param string $paymentId
     * @param Money $amountMoney
     * @param string $reason
     * @param string $deviceId
     */
    public function __construct(string $paymentId, Money $amountMoney, string $reason, string $deviceId)
    {
        $this->paymentId = $paymentId;
        $this->amountMoney = $amountMoney;
        $this->reason = $reason;
        $this->deviceId = $deviceId;
    }

    /**
     * Returns Id.
     * A unique ID for this `TerminalRefund`.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique ID for this `TerminalRefund`.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Refund Id.
     * The reference to the payment refund created by completing this `TerminalRefund`.
     */
    public function getRefundId(): ?string
    {
        return $this->refundId;
    }

    /**
     * Sets Refund Id.
     * The reference to the payment refund created by completing this `TerminalRefund`.
     *
     * @maps refund_id
     */
    public function setRefundId(?string $refundId): void
    {
        $this->refundId = $refundId;
    }

    /**
     * Returns Payment Id.
     * The unique ID of the payment being refunded.
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     * The unique ID of the payment being refunded.
     *
     * @required
     * @maps payment_id
     */
    public function setPaymentId(string $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Returns Order Id.
     * The reference to the Square order ID for the payment identified by the `payment_id`.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The reference to the Square order ID for the payment identified by the `payment_id`.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
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
     * Returns Reason.
     * A description of the reason for the refund.
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Sets Reason.
     * A description of the reason for the refund.
     *
     * @required
     * @maps reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * Returns Device Id.
     * The unique ID of the device intended for this `TerminalRefund`.
     * The Id can be retrieved from /v2/devices api.
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * Sets Device Id.
     * The unique ID of the device intended for this `TerminalRefund`.
     * The Id can be retrieved from /v2/devices api.
     *
     * @required
     * @maps device_id
     */
    public function setDeviceId(string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Returns Deadline Duration.
     * The RFC 3339 duration, after which the refund is automatically canceled.
     * A `TerminalRefund` that is `PENDING` is automatically `CANCELED` and has a cancellation reason
     * of `TIMED_OUT`.
     *
     * Default: 5 minutes from creation.
     *
     * Maximum: 5 minutes
     */
    public function getDeadlineDuration(): ?string
    {
        if (count($this->deadlineDuration) == 0) {
            return null;
        }
        return $this->deadlineDuration['value'];
    }

    /**
     * Sets Deadline Duration.
     * The RFC 3339 duration, after which the refund is automatically canceled.
     * A `TerminalRefund` that is `PENDING` is automatically `CANCELED` and has a cancellation reason
     * of `TIMED_OUT`.
     *
     * Default: 5 minutes from creation.
     *
     * Maximum: 5 minutes
     *
     * @maps deadline_duration
     */
    public function setDeadlineDuration(?string $deadlineDuration): void
    {
        $this->deadlineDuration['value'] = $deadlineDuration;
    }

    /**
     * Unsets Deadline Duration.
     * The RFC 3339 duration, after which the refund is automatically canceled.
     * A `TerminalRefund` that is `PENDING` is automatically `CANCELED` and has a cancellation reason
     * of `TIMED_OUT`.
     *
     * Default: 5 minutes from creation.
     *
     * Maximum: 5 minutes
     */
    public function unsetDeadlineDuration(): void
    {
        $this->deadlineDuration = [];
    }

    /**
     * Returns Status.
     * The status of the `TerminalRefund`.
     * Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, or `COMPLETED`.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * The status of the `TerminalRefund`.
     * Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, or `COMPLETED`.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Cancel Reason.
     */
    public function getCancelReason(): ?string
    {
        return $this->cancelReason;
    }

    /**
     * Sets Cancel Reason.
     *
     * @maps cancel_reason
     */
    public function setCancelReason(?string $cancelReason): void
    {
        $this->cancelReason = $cancelReason;
    }

    /**
     * Returns Created At.
     * The time when the `TerminalRefund` was created, as an RFC 3339 timestamp.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The time when the `TerminalRefund` was created, as an RFC 3339 timestamp.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The time when the `TerminalRefund` was last updated, as an RFC 3339 timestamp.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The time when the `TerminalRefund` was last updated, as an RFC 3339 timestamp.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns App Id.
     * The ID of the application that created the refund.
     */
    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * Sets App Id.
     * The ID of the application that created the refund.
     *
     * @maps app_id
     */
    public function setAppId(?string $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * Returns Location Id.
     * The location of the device where the `TerminalRefund` was directed.
     */
    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The location of the device where the `TerminalRefund` was directed.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId = $locationId;
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
            $json['id']                = $this->id;
        }
        if (isset($this->refundId)) {
            $json['refund_id']         = $this->refundId;
        }
        $json['payment_id']            = $this->paymentId;
        if (isset($this->orderId)) {
            $json['order_id']          = $this->orderId;
        }
        $json['amount_money']          = $this->amountMoney;
        $json['reason']                = $this->reason;
        $json['device_id']             = $this->deviceId;
        if (!empty($this->deadlineDuration)) {
            $json['deadline_duration'] = $this->deadlineDuration['value'];
        }
        if (isset($this->status)) {
            $json['status']            = $this->status;
        }
        if (isset($this->cancelReason)) {
            $json['cancel_reason']     = $this->cancelReason;
        }
        if (isset($this->createdAt)) {
            $json['created_at']        = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']        = $this->updatedAt;
        }
        if (isset($this->appId)) {
            $json['app_id']            = $this->appId;
        }
        if (isset($this->locationId)) {
            $json['location_id']       = $this->locationId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
