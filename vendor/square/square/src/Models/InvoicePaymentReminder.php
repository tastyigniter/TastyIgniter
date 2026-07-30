<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes a payment request reminder (automatic notification) that Square sends
 * to the customer. You configure a reminder relative to the payment request
 * `due_date`.
 */
class InvoicePaymentReminder implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $uid;

    /**
     * @var array
     */
    private $relativeScheduledDays = [];

    /**
     * @var array
     */
    private $message = [];

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $sentAt;

    /**
     * Returns Uid.
     * A Square-assigned ID that uniquely identifies the reminder within the
     * `InvoicePaymentRequest`.
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * Sets Uid.
     * A Square-assigned ID that uniquely identifies the reminder within the
     * `InvoicePaymentRequest`.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * Returns Relative Scheduled Days.
     * The number of days before (a negative number) or after (a positive number)
     * the payment request `due_date` when the reminder is sent. For example, -3 indicates that
     * the reminder should be sent 3 days before the payment request `due_date`.
     */
    public function getRelativeScheduledDays(): ?int
    {
        if (count($this->relativeScheduledDays) == 0) {
            return null;
        }
        return $this->relativeScheduledDays['value'];
    }

    /**
     * Sets Relative Scheduled Days.
     * The number of days before (a negative number) or after (a positive number)
     * the payment request `due_date` when the reminder is sent. For example, -3 indicates that
     * the reminder should be sent 3 days before the payment request `due_date`.
     *
     * @maps relative_scheduled_days
     */
    public function setRelativeScheduledDays(?int $relativeScheduledDays): void
    {
        $this->relativeScheduledDays['value'] = $relativeScheduledDays;
    }

    /**
     * Unsets Relative Scheduled Days.
     * The number of days before (a negative number) or after (a positive number)
     * the payment request `due_date` when the reminder is sent. For example, -3 indicates that
     * the reminder should be sent 3 days before the payment request `due_date`.
     */
    public function unsetRelativeScheduledDays(): void
    {
        $this->relativeScheduledDays = [];
    }

    /**
     * Returns Message.
     * The reminder message.
     */
    public function getMessage(): ?string
    {
        if (count($this->message) == 0) {
            return null;
        }
        return $this->message['value'];
    }

    /**
     * Sets Message.
     * The reminder message.
     *
     * @maps message
     */
    public function setMessage(?string $message): void
    {
        $this->message['value'] = $message;
    }

    /**
     * Unsets Message.
     * The reminder message.
     */
    public function unsetMessage(): void
    {
        $this->message = [];
    }

    /**
     * Returns Status.
     * The status of a payment request reminder.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * The status of a payment request reminder.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Sent At.
     * If sent, the timestamp when the reminder was sent, in RFC 3339 format.
     */
    public function getSentAt(): ?string
    {
        return $this->sentAt;
    }

    /**
     * Sets Sent At.
     * If sent, the timestamp when the reminder was sent, in RFC 3339 format.
     *
     * @maps sent_at
     */
    public function setSentAt(?string $sentAt): void
    {
        $this->sentAt = $sentAt;
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
        if (isset($this->uid)) {
            $json['uid']                     = $this->uid;
        }
        if (!empty($this->relativeScheduledDays)) {
            $json['relative_scheduled_days'] = $this->relativeScheduledDays['value'];
        }
        if (!empty($this->message)) {
            $json['message']                 = $this->message['value'];
        }
        if (isset($this->status)) {
            $json['status']                  = $this->status;
        }
        if (isset($this->sentAt)) {
            $json['sent_at']                 = $this->sentAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
