<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * V1UpdateOrderRequest
 */
class V1UpdateOrderRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $shippedTrackingNumber = [];

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
     * @param string $action
     */
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    /**
     * Returns Action.
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Sets Action.
     *
     * @required
     * @maps action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * Returns Shipped Tracking Number.
     * The tracking number of the shipment associated with the order. Only valid if action is COMPLETE.
     */
    public function getShippedTrackingNumber(): ?string
    {
        if (count($this->shippedTrackingNumber) == 0) {
            return null;
        }
        return $this->shippedTrackingNumber['value'];
    }

    /**
     * Sets Shipped Tracking Number.
     * The tracking number of the shipment associated with the order. Only valid if action is COMPLETE.
     *
     * @maps shipped_tracking_number
     */
    public function setShippedTrackingNumber(?string $shippedTrackingNumber): void
    {
        $this->shippedTrackingNumber['value'] = $shippedTrackingNumber;
    }

    /**
     * Unsets Shipped Tracking Number.
     * The tracking number of the shipment associated with the order. Only valid if action is COMPLETE.
     */
    public function unsetShippedTrackingNumber(): void
    {
        $this->shippedTrackingNumber = [];
    }

    /**
     * Returns Completed Note.
     * A merchant-specified note about the completion of the order. Only valid if action is COMPLETE.
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
     * A merchant-specified note about the completion of the order. Only valid if action is COMPLETE.
     *
     * @maps completed_note
     */
    public function setCompletedNote(?string $completedNote): void
    {
        $this->completedNote['value'] = $completedNote;
    }

    /**
     * Unsets Completed Note.
     * A merchant-specified note about the completion of the order. Only valid if action is COMPLETE.
     */
    public function unsetCompletedNote(): void
    {
        $this->completedNote = [];
    }

    /**
     * Returns Refunded Note.
     * A merchant-specified note about the refunding of the order. Only valid if action is REFUND.
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
     * A merchant-specified note about the refunding of the order. Only valid if action is REFUND.
     *
     * @maps refunded_note
     */
    public function setRefundedNote(?string $refundedNote): void
    {
        $this->refundedNote['value'] = $refundedNote;
    }

    /**
     * Unsets Refunded Note.
     * A merchant-specified note about the refunding of the order. Only valid if action is REFUND.
     */
    public function unsetRefundedNote(): void
    {
        $this->refundedNote = [];
    }

    /**
     * Returns Canceled Note.
     * A merchant-specified note about the canceling of the order. Only valid if action is CANCEL.
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
     * A merchant-specified note about the canceling of the order. Only valid if action is CANCEL.
     *
     * @maps canceled_note
     */
    public function setCanceledNote(?string $canceledNote): void
    {
        $this->canceledNote['value'] = $canceledNote;
    }

    /**
     * Unsets Canceled Note.
     * A merchant-specified note about the canceling of the order. Only valid if action is CANCEL.
     */
    public function unsetCanceledNote(): void
    {
        $this->canceledNote = [];
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
        $json['action']                      = $this->action;
        if (!empty($this->shippedTrackingNumber)) {
            $json['shipped_tracking_number'] = $this->shippedTrackingNumber['value'];
        }
        if (!empty($this->completedNote)) {
            $json['completed_note']          = $this->completedNote['value'];
        }
        if (!empty($this->refundedNote)) {
            $json['refunded_note']           = $this->refundedNote['value'];
        }
        if (!empty($this->canceledNote)) {
            $json['canceled_note']           = $this->canceledNote['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
