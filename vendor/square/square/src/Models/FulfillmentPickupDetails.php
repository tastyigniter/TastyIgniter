<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains details necessary to fulfill a pickup order.
 */
class FulfillmentPickupDetails implements \JsonSerializable
{
    /**
     * @var FulfillmentRecipient|null
     */
    private $recipient;

    /**
     * @var array
     */
    private $expiresAt = [];

    /**
     * @var array
     */
    private $autoCompleteDuration = [];

    /**
     * @var string|null
     */
    private $scheduleType;

    /**
     * @var array
     */
    private $pickupAt = [];

    /**
     * @var array
     */
    private $pickupWindowDuration = [];

    /**
     * @var array
     */
    private $prepTimeDuration = [];

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var string|null
     */
    private $placedAt;

    /**
     * @var string|null
     */
    private $acceptedAt;

    /**
     * @var string|null
     */
    private $rejectedAt;

    /**
     * @var string|null
     */
    private $readyAt;

    /**
     * @var string|null
     */
    private $expiredAt;

    /**
     * @var string|null
     */
    private $pickedUpAt;

    /**
     * @var string|null
     */
    private $canceledAt;

    /**
     * @var array
     */
    private $cancelReason = [];

    /**
     * @var array
     */
    private $isCurbsidePickup = [];

    /**
     * @var FulfillmentPickupDetailsCurbsidePickupDetails|null
     */
    private $curbsidePickupDetails;

    /**
     * Returns Recipient.
     * Information about the fulfillment recipient.
     */
    public function getRecipient(): ?FulfillmentRecipient
    {
        return $this->recipient;
    }

    /**
     * Sets Recipient.
     * Information about the fulfillment recipient.
     *
     * @maps recipient
     */
    public function setRecipient(?FulfillmentRecipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * Returns Expires At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment expires if it is not accepted. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z"). The expiration time can only be set up to 7 days in the
     * future.
     * If `expires_at` is not set, this pickup fulfillment is automatically accepted when
     * placed.
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
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment expires if it is not accepted. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z"). The expiration time can only be set up to 7 days in the
     * future.
     * If `expires_at` is not set, this pickup fulfillment is automatically accepted when
     * placed.
     *
     * @maps expires_at
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt['value'] = $expiresAt;
    }

    /**
     * Unsets Expires At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment expires if it is not accepted. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z"). The expiration time can only be set up to 7 days in the
     * future.
     * If `expires_at` is not set, this pickup fulfillment is automatically accepted when
     * placed.
     */
    public function unsetExpiresAt(): void
    {
        $this->expiresAt = [];
    }

    /**
     * Returns Auto Complete Duration.
     * The duration of time after which an open and accepted pickup fulfillment
     * is automatically moved to the `COMPLETED` state. The duration must be in RFC 3339
     * format (for example, "P1W3D").
     *
     * If not set, this pickup fulfillment remains accepted until it is canceled or completed.
     */
    public function getAutoCompleteDuration(): ?string
    {
        if (count($this->autoCompleteDuration) == 0) {
            return null;
        }
        return $this->autoCompleteDuration['value'];
    }

    /**
     * Sets Auto Complete Duration.
     * The duration of time after which an open and accepted pickup fulfillment
     * is automatically moved to the `COMPLETED` state. The duration must be in RFC 3339
     * format (for example, "P1W3D").
     *
     * If not set, this pickup fulfillment remains accepted until it is canceled or completed.
     *
     * @maps auto_complete_duration
     */
    public function setAutoCompleteDuration(?string $autoCompleteDuration): void
    {
        $this->autoCompleteDuration['value'] = $autoCompleteDuration;
    }

    /**
     * Unsets Auto Complete Duration.
     * The duration of time after which an open and accepted pickup fulfillment
     * is automatically moved to the `COMPLETED` state. The duration must be in RFC 3339
     * format (for example, "P1W3D").
     *
     * If not set, this pickup fulfillment remains accepted until it is canceled or completed.
     */
    public function unsetAutoCompleteDuration(): void
    {
        $this->autoCompleteDuration = [];
    }

    /**
     * Returns Schedule Type.
     * The schedule type of the pickup fulfillment.
     */
    public function getScheduleType(): ?string
    {
        return $this->scheduleType;
    }

    /**
     * Sets Schedule Type.
     * The schedule type of the pickup fulfillment.
     *
     * @maps schedule_type
     */
    public function setScheduleType(?string $scheduleType): void
    {
        $this->scheduleType = $scheduleType;
    }

    /**
     * Returns Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the pickup window. Must be in RFC 3339 timestamp format, e.g.,
     * "2016-09-04T23:59:33.123Z".
     *
     * For fulfillments with the schedule type `ASAP`, this is automatically set
     * to the current time plus the expected duration to prepare the fulfillment.
     */
    public function getPickupAt(): ?string
    {
        if (count($this->pickupAt) == 0) {
            return null;
        }
        return $this->pickupAt['value'];
    }

    /**
     * Sets Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the pickup window. Must be in RFC 3339 timestamp format, e.g.,
     * "2016-09-04T23:59:33.123Z".
     *
     * For fulfillments with the schedule type `ASAP`, this is automatically set
     * to the current time plus the expected duration to prepare the fulfillment.
     *
     * @maps pickup_at
     */
    public function setPickupAt(?string $pickupAt): void
    {
        $this->pickupAt['value'] = $pickupAt;
    }

    /**
     * Unsets Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the pickup window. Must be in RFC 3339 timestamp format, e.g.,
     * "2016-09-04T23:59:33.123Z".
     *
     * For fulfillments with the schedule type `ASAP`, this is automatically set
     * to the current time plus the expected duration to prepare the fulfillment.
     */
    public function unsetPickupAt(): void
    {
        $this->pickupAt = [];
    }

    /**
     * Returns Pickup Window Duration.
     * The window of time in which the order should be picked up after the `pickup_at` timestamp.
     * Must be in RFC 3339 duration format, e.g., "P1W3D". Can be used as an
     * informational guideline for merchants.
     */
    public function getPickupWindowDuration(): ?string
    {
        if (count($this->pickupWindowDuration) == 0) {
            return null;
        }
        return $this->pickupWindowDuration['value'];
    }

    /**
     * Sets Pickup Window Duration.
     * The window of time in which the order should be picked up after the `pickup_at` timestamp.
     * Must be in RFC 3339 duration format, e.g., "P1W3D". Can be used as an
     * informational guideline for merchants.
     *
     * @maps pickup_window_duration
     */
    public function setPickupWindowDuration(?string $pickupWindowDuration): void
    {
        $this->pickupWindowDuration['value'] = $pickupWindowDuration;
    }

    /**
     * Unsets Pickup Window Duration.
     * The window of time in which the order should be picked up after the `pickup_at` timestamp.
     * Must be in RFC 3339 duration format, e.g., "P1W3D". Can be used as an
     * informational guideline for merchants.
     */
    public function unsetPickupWindowDuration(): void
    {
        $this->pickupWindowDuration = [];
    }

    /**
     * Returns Prep Time Duration.
     * The duration of time it takes to prepare this fulfillment.
     * The duration must be in RFC 3339 format (for example, "P1W3D").
     */
    public function getPrepTimeDuration(): ?string
    {
        if (count($this->prepTimeDuration) == 0) {
            return null;
        }
        return $this->prepTimeDuration['value'];
    }

    /**
     * Sets Prep Time Duration.
     * The duration of time it takes to prepare this fulfillment.
     * The duration must be in RFC 3339 format (for example, "P1W3D").
     *
     * @maps prep_time_duration
     */
    public function setPrepTimeDuration(?string $prepTimeDuration): void
    {
        $this->prepTimeDuration['value'] = $prepTimeDuration;
    }

    /**
     * Unsets Prep Time Duration.
     * The duration of time it takes to prepare this fulfillment.
     * The duration must be in RFC 3339 format (for example, "P1W3D").
     */
    public function unsetPrepTimeDuration(): void
    {
        $this->prepTimeDuration = [];
    }

    /**
     * Returns Note.
     * A note to provide additional instructions about the pickup
     * fulfillment displayed in the Square Point of Sale application and set by the API.
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
     * A note to provide additional instructions about the pickup
     * fulfillment displayed in the Square Point of Sale application and set by the API.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * A note to provide additional instructions about the pickup
     * fulfillment displayed in the Square Point of Sale application and set by the API.
     */
    public function unsetNote(): void
    {
        $this->note = [];
    }

    /**
     * Returns Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was placed. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getPlacedAt(): ?string
    {
        return $this->placedAt;
    }

    /**
     * Sets Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was placed. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps placed_at
     */
    public function setPlacedAt(?string $placedAt): void
    {
        $this->placedAt = $placedAt;
    }

    /**
     * Returns Accepted At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was accepted. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getAcceptedAt(): ?string
    {
        return $this->acceptedAt;
    }

    /**
     * Sets Accepted At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was accepted. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps accepted_at
     */
    public function setAcceptedAt(?string $acceptedAt): void
    {
        $this->acceptedAt = $acceptedAt;
    }

    /**
     * Returns Rejected At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was rejected. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getRejectedAt(): ?string
    {
        return $this->rejectedAt;
    }

    /**
     * Sets Rejected At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was rejected. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps rejected_at
     */
    public function setRejectedAt(?string $rejectedAt): void
    {
        $this->rejectedAt = $rejectedAt;
    }

    /**
     * Returns Ready At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment is marked as ready for pickup. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getReadyAt(): ?string
    {
        return $this->readyAt;
    }

    /**
     * Sets Ready At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment is marked as ready for pickup. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps ready_at
     */
    public function setReadyAt(?string $readyAt): void
    {
        $this->readyAt = $readyAt;
    }

    /**
     * Returns Expired At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment expired. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getExpiredAt(): ?string
    {
        return $this->expiredAt;
    }

    /**
     * Sets Expired At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment expired. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps expired_at
     */
    public function setExpiredAt(?string $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * Returns Picked up At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was picked up by the recipient. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getPickedUpAt(): ?string
    {
        return $this->pickedUpAt;
    }

    /**
     * Sets Picked up At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was picked up by the recipient. The timestamp must be in RFC 3339
     * format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps picked_up_at
     */
    public function setPickedUpAt(?string $pickedUpAt): void
    {
        $this->pickedUpAt = $pickedUpAt;
    }

    /**
     * Returns Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was canceled. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getCanceledAt(): ?string
    {
        return $this->canceledAt;
    }

    /**
     * Sets Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was canceled. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps canceled_at
     */
    public function setCanceledAt(?string $canceledAt): void
    {
        $this->canceledAt = $canceledAt;
    }

    /**
     * Returns Cancel Reason.
     * A description of why the pickup was canceled. The maximum length: 100 characters.
     */
    public function getCancelReason(): ?string
    {
        if (count($this->cancelReason) == 0) {
            return null;
        }
        return $this->cancelReason['value'];
    }

    /**
     * Sets Cancel Reason.
     * A description of why the pickup was canceled. The maximum length: 100 characters.
     *
     * @maps cancel_reason
     */
    public function setCancelReason(?string $cancelReason): void
    {
        $this->cancelReason['value'] = $cancelReason;
    }

    /**
     * Unsets Cancel Reason.
     * A description of why the pickup was canceled. The maximum length: 100 characters.
     */
    public function unsetCancelReason(): void
    {
        $this->cancelReason = [];
    }

    /**
     * Returns Is Curbside Pickup.
     * If set to `true`, indicates that this pickup order is for curbside pickup, not in-store pickup.
     */
    public function getIsCurbsidePickup(): ?bool
    {
        if (count($this->isCurbsidePickup) == 0) {
            return null;
        }
        return $this->isCurbsidePickup['value'];
    }

    /**
     * Sets Is Curbside Pickup.
     * If set to `true`, indicates that this pickup order is for curbside pickup, not in-store pickup.
     *
     * @maps is_curbside_pickup
     */
    public function setIsCurbsidePickup(?bool $isCurbsidePickup): void
    {
        $this->isCurbsidePickup['value'] = $isCurbsidePickup;
    }

    /**
     * Unsets Is Curbside Pickup.
     * If set to `true`, indicates that this pickup order is for curbside pickup, not in-store pickup.
     */
    public function unsetIsCurbsidePickup(): void
    {
        $this->isCurbsidePickup = [];
    }

    /**
     * Returns Curbside Pickup Details.
     * Specific details for curbside pickup.
     */
    public function getCurbsidePickupDetails(): ?FulfillmentPickupDetailsCurbsidePickupDetails
    {
        return $this->curbsidePickupDetails;
    }

    /**
     * Sets Curbside Pickup Details.
     * Specific details for curbside pickup.
     *
     * @maps curbside_pickup_details
     */
    public function setCurbsidePickupDetails(
        ?FulfillmentPickupDetailsCurbsidePickupDetails $curbsidePickupDetails
    ): void {
        $this->curbsidePickupDetails = $curbsidePickupDetails;
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
        if (isset($this->recipient)) {
            $json['recipient']               = $this->recipient;
        }
        if (!empty($this->expiresAt)) {
            $json['expires_at']              = $this->expiresAt['value'];
        }
        if (!empty($this->autoCompleteDuration)) {
            $json['auto_complete_duration']  = $this->autoCompleteDuration['value'];
        }
        if (isset($this->scheduleType)) {
            $json['schedule_type']           = $this->scheduleType;
        }
        if (!empty($this->pickupAt)) {
            $json['pickup_at']               = $this->pickupAt['value'];
        }
        if (!empty($this->pickupWindowDuration)) {
            $json['pickup_window_duration']  = $this->pickupWindowDuration['value'];
        }
        if (!empty($this->prepTimeDuration)) {
            $json['prep_time_duration']      = $this->prepTimeDuration['value'];
        }
        if (!empty($this->note)) {
            $json['note']                    = $this->note['value'];
        }
        if (isset($this->placedAt)) {
            $json['placed_at']               = $this->placedAt;
        }
        if (isset($this->acceptedAt)) {
            $json['accepted_at']             = $this->acceptedAt;
        }
        if (isset($this->rejectedAt)) {
            $json['rejected_at']             = $this->rejectedAt;
        }
        if (isset($this->readyAt)) {
            $json['ready_at']                = $this->readyAt;
        }
        if (isset($this->expiredAt)) {
            $json['expired_at']              = $this->expiredAt;
        }
        if (isset($this->pickedUpAt)) {
            $json['picked_up_at']            = $this->pickedUpAt;
        }
        if (isset($this->canceledAt)) {
            $json['canceled_at']             = $this->canceledAt;
        }
        if (!empty($this->cancelReason)) {
            $json['cancel_reason']           = $this->cancelReason['value'];
        }
        if (!empty($this->isCurbsidePickup)) {
            $json['is_curbside_pickup']      = $this->isCurbsidePickup['value'];
        }
        if (isset($this->curbsidePickupDetails)) {
            $json['curbside_pickup_details'] = $this->curbsidePickupDetails;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
