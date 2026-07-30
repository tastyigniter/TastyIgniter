<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes delivery details of an order fulfillment.
 */
class OrderFulfillmentDeliveryDetails implements \JsonSerializable
{
    /**
     * @var OrderFulfillmentRecipient|null
     */
    private $recipient;

    /**
     * @var string|null
     */
    private $scheduleType;

    /**
     * @var string|null
     */
    private $placedAt;

    /**
     * @var array
     */
    private $deliverAt = [];

    /**
     * @var array
     */
    private $prepTimeDuration = [];

    /**
     * @var array
     */
    private $deliveryWindowDuration = [];

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var array
     */
    private $completedAt = [];

    /**
     * @var string|null
     */
    private $inProgressAt;

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
    private $deliveredAt;

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
    private $courierPickupAt = [];

    /**
     * @var array
     */
    private $courierPickupWindowDuration = [];

    /**
     * @var array
     */
    private $isNoContactDelivery = [];

    /**
     * @var array
     */
    private $dropoffNotes = [];

    /**
     * @var array
     */
    private $courierProviderName = [];

    /**
     * @var array
     */
    private $courierSupportPhoneNumber = [];

    /**
     * @var array
     */
    private $squareDeliveryId = [];

    /**
     * @var array
     */
    private $externalDeliveryId = [];

    /**
     * @var array
     */
    private $managedDelivery = [];

    /**
     * Returns Recipient.
     * Information about the fulfillment recipient.
     */
    public function getRecipient(): ?OrderFulfillmentRecipient
    {
        return $this->recipient;
    }

    /**
     * Sets Recipient.
     * Information about the fulfillment recipient.
     *
     * @maps recipient
     */
    public function setRecipient(?OrderFulfillmentRecipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * Returns Schedule Type.
     * The schedule type of the delivery fulfillment.
     */
    public function getScheduleType(): ?string
    {
        return $this->scheduleType;
    }

    /**
     * Sets Schedule Type.
     * The schedule type of the delivery fulfillment.
     *
     * @maps schedule_type
     */
    public function setScheduleType(?string $scheduleType): void
    {
        $this->scheduleType = $scheduleType;
    }

    /**
     * Returns Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was placed.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     * Must be in RFC 3339 timestamp format, e.g., "2016-09-04T23:59:33.123Z".
     */
    public function getPlacedAt(): ?string
    {
        return $this->placedAt;
    }

    /**
     * Sets Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was placed.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     * Must be in RFC 3339 timestamp format, e.g., "2016-09-04T23:59:33.123Z".
     *
     * @maps placed_at
     */
    public function setPlacedAt(?string $placedAt): void
    {
        $this->placedAt = $placedAt;
    }

    /**
     * Returns Deliver At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the delivery period.
     * When the fulfillment `schedule_type` is `ASAP`, the field is automatically
     * set to the current time plus the `prep_time_duration`.
     * Otherwise, the application can set this field while the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the
     * terminal state such as `COMPLETED`, `CANCELED`, and `FAILED`).
     *
     * The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getDeliverAt(): ?string
    {
        if (count($this->deliverAt) == 0) {
            return null;
        }
        return $this->deliverAt['value'];
    }

    /**
     * Sets Deliver At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the delivery period.
     * When the fulfillment `schedule_type` is `ASAP`, the field is automatically
     * set to the current time plus the `prep_time_duration`.
     * Otherwise, the application can set this field while the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the
     * terminal state such as `COMPLETED`, `CANCELED`, and `FAILED`).
     *
     * The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps deliver_at
     */
    public function setDeliverAt(?string $deliverAt): void
    {
        $this->deliverAt['value'] = $deliverAt;
    }

    /**
     * Unsets Deliver At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * that represents the start of the delivery period.
     * When the fulfillment `schedule_type` is `ASAP`, the field is automatically
     * set to the current time plus the `prep_time_duration`.
     * Otherwise, the application can set this field while the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the
     * terminal state such as `COMPLETED`, `CANCELED`, and `FAILED`).
     *
     * The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetDeliverAt(): void
    {
        $this->deliverAt = [];
    }

    /**
     * Returns Prep Time Duration.
     * The duration of time it takes to prepare and deliver this fulfillment.
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
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
     * The duration of time it takes to prepare and deliver this fulfillment.
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
     *
     * @maps prep_time_duration
     */
    public function setPrepTimeDuration(?string $prepTimeDuration): void
    {
        $this->prepTimeDuration['value'] = $prepTimeDuration;
    }

    /**
     * Unsets Prep Time Duration.
     * The duration of time it takes to prepare and deliver this fulfillment.
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
     */
    public function unsetPrepTimeDuration(): void
    {
        $this->prepTimeDuration = [];
    }

    /**
     * Returns Delivery Window Duration.
     * The time period after the `deliver_at` timestamp in which to deliver the order.
     * Applications can set this field when the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the terminal state
     * such as `COMPLETED`, `CANCELED`, and `FAILED`).
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
     */
    public function getDeliveryWindowDuration(): ?string
    {
        if (count($this->deliveryWindowDuration) == 0) {
            return null;
        }
        return $this->deliveryWindowDuration['value'];
    }

    /**
     * Sets Delivery Window Duration.
     * The time period after the `deliver_at` timestamp in which to deliver the order.
     * Applications can set this field when the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the terminal state
     * such as `COMPLETED`, `CANCELED`, and `FAILED`).
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
     *
     * @maps delivery_window_duration
     */
    public function setDeliveryWindowDuration(?string $deliveryWindowDuration): void
    {
        $this->deliveryWindowDuration['value'] = $deliveryWindowDuration;
    }

    /**
     * Unsets Delivery Window Duration.
     * The time period after the `deliver_at` timestamp in which to deliver the order.
     * Applications can set this field when the fulfillment `state` is
     * `PROPOSED`, `RESERVED`, or `PREPARED` (any time before the terminal state
     * such as `COMPLETED`, `CANCELED`, and `FAILED`).
     * The timestamp must be in RFC 3339 format (for example, "P1W3D").
     */
    public function unsetDeliveryWindowDuration(): void
    {
        $this->deliveryWindowDuration = [];
    }

    /**
     * Returns Note.
     * Provides additional instructions about the delivery fulfillment.
     * It is displayed in the Square Point of Sale application and set by the API.
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
     * Provides additional instructions about the delivery fulfillment.
     * It is displayed in the Square Point of Sale application and set by the API.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * Provides additional instructions about the delivery fulfillment.
     * It is displayed in the Square Point of Sale application and set by the API.
     */
    public function unsetNote(): void
    {
        $this->note = [];
    }

    /**
     * Returns Completed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicates when the seller completed the fulfillment.
     * This field is automatically set when  fulfillment `state` changes to `COMPLETED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getCompletedAt(): ?string
    {
        if (count($this->completedAt) == 0) {
            return null;
        }
        return $this->completedAt['value'];
    }

    /**
     * Sets Completed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicates when the seller completed the fulfillment.
     * This field is automatically set when  fulfillment `state` changes to `COMPLETED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps completed_at
     */
    public function setCompletedAt(?string $completedAt): void
    {
        $this->completedAt['value'] = $completedAt;
    }

    /**
     * Unsets Completed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicates when the seller completed the fulfillment.
     * This field is automatically set when  fulfillment `state` changes to `COMPLETED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetCompletedAt(): void
    {
        $this->completedAt = [];
    }

    /**
     * Returns In Progress At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicates when the seller started processing the fulfillment.
     * This field is automatically set when the fulfillment `state` changes to `RESERVED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getInProgressAt(): ?string
    {
        return $this->inProgressAt;
    }

    /**
     * Sets In Progress At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicates when the seller started processing the fulfillment.
     * This field is automatically set when the fulfillment `state` changes to `RESERVED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps in_progress_at
     */
    public function setInProgressAt(?string $inProgressAt): void
    {
        $this->inProgressAt = $inProgressAt;
    }

    /**
     * Returns Rejected At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was rejected. This field is
     * automatically set when the fulfillment `state` changes to `FAILED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getRejectedAt(): ?string
    {
        return $this->rejectedAt;
    }

    /**
     * Sets Rejected At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was rejected. This field is
     * automatically set when the fulfillment `state` changes to `FAILED`.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
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
     * indicating when the seller marked the fulfillment as ready for
     * courier pickup. This field is automatically set when the fulfillment `state` changes
     * to PREPARED.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getReadyAt(): ?string
    {
        return $this->readyAt;
    }

    /**
     * Sets Ready At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the seller marked the fulfillment as ready for
     * courier pickup. This field is automatically set when the fulfillment `state` changes
     * to PREPARED.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps ready_at
     */
    public function setReadyAt(?string $readyAt): void
    {
        $this->readyAt = $readyAt;
    }

    /**
     * Returns Delivered At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was delivered to the recipient.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getDeliveredAt(): ?string
    {
        return $this->deliveredAt;
    }

    /**
     * Sets Delivered At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was delivered to the recipient.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps delivered_at
     */
    public function setDeliveredAt(?string $deliveredAt): void
    {
        $this->deliveredAt = $deliveredAt;
    }

    /**
     * Returns Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was canceled. This field is automatically
     * set when the fulfillment `state` changes to `CANCELED`.
     *
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getCanceledAt(): ?string
    {
        return $this->canceledAt;
    }

    /**
     * Sets Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the fulfillment was canceled. This field is automatically
     * set when the fulfillment `state` changes to `CANCELED`.
     *
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps canceled_at
     */
    public function setCanceledAt(?string $canceledAt): void
    {
        $this->canceledAt = $canceledAt;
    }

    /**
     * Returns Cancel Reason.
     * The delivery cancellation reason. Max length: 100 characters.
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
     * The delivery cancellation reason. Max length: 100 characters.
     *
     * @maps cancel_reason
     */
    public function setCancelReason(?string $cancelReason): void
    {
        $this->cancelReason['value'] = $cancelReason;
    }

    /**
     * Unsets Cancel Reason.
     * The delivery cancellation reason. Max length: 100 characters.
     */
    public function unsetCancelReason(): void
    {
        $this->cancelReason = [];
    }

    /**
     * Returns Courier Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when an order can be picked up by the courier for delivery.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getCourierPickupAt(): ?string
    {
        if (count($this->courierPickupAt) == 0) {
            return null;
        }
        return $this->courierPickupAt['value'];
    }

    /**
     * Sets Courier Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when an order can be picked up by the courier for delivery.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps courier_pickup_at
     */
    public function setCourierPickupAt(?string $courierPickupAt): void
    {
        $this->courierPickupAt['value'] = $courierPickupAt;
    }

    /**
     * Unsets Courier Pickup At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when an order can be picked up by the courier for delivery.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetCourierPickupAt(): void
    {
        $this->courierPickupAt = [];
    }

    /**
     * Returns Courier Pickup Window Duration.
     * The period of time in which the order should be picked up by the courier after the
     * `courier_pickup_at` timestamp.
     * The time must be in RFC 3339 format (for example, "P1W3D").
     */
    public function getCourierPickupWindowDuration(): ?string
    {
        if (count($this->courierPickupWindowDuration) == 0) {
            return null;
        }
        return $this->courierPickupWindowDuration['value'];
    }

    /**
     * Sets Courier Pickup Window Duration.
     * The period of time in which the order should be picked up by the courier after the
     * `courier_pickup_at` timestamp.
     * The time must be in RFC 3339 format (for example, "P1W3D").
     *
     * @maps courier_pickup_window_duration
     */
    public function setCourierPickupWindowDuration(?string $courierPickupWindowDuration): void
    {
        $this->courierPickupWindowDuration['value'] = $courierPickupWindowDuration;
    }

    /**
     * Unsets Courier Pickup Window Duration.
     * The period of time in which the order should be picked up by the courier after the
     * `courier_pickup_at` timestamp.
     * The time must be in RFC 3339 format (for example, "P1W3D").
     */
    public function unsetCourierPickupWindowDuration(): void
    {
        $this->courierPickupWindowDuration = [];
    }

    /**
     * Returns Is No Contact Delivery.
     * Whether the delivery is preferred to be no contact.
     */
    public function getIsNoContactDelivery(): ?bool
    {
        if (count($this->isNoContactDelivery) == 0) {
            return null;
        }
        return $this->isNoContactDelivery['value'];
    }

    /**
     * Sets Is No Contact Delivery.
     * Whether the delivery is preferred to be no contact.
     *
     * @maps is_no_contact_delivery
     */
    public function setIsNoContactDelivery(?bool $isNoContactDelivery): void
    {
        $this->isNoContactDelivery['value'] = $isNoContactDelivery;
    }

    /**
     * Unsets Is No Contact Delivery.
     * Whether the delivery is preferred to be no contact.
     */
    public function unsetIsNoContactDelivery(): void
    {
        $this->isNoContactDelivery = [];
    }

    /**
     * Returns Dropoff Notes.
     * A note to provide additional instructions about how to deliver the order.
     */
    public function getDropoffNotes(): ?string
    {
        if (count($this->dropoffNotes) == 0) {
            return null;
        }
        return $this->dropoffNotes['value'];
    }

    /**
     * Sets Dropoff Notes.
     * A note to provide additional instructions about how to deliver the order.
     *
     * @maps dropoff_notes
     */
    public function setDropoffNotes(?string $dropoffNotes): void
    {
        $this->dropoffNotes['value'] = $dropoffNotes;
    }

    /**
     * Unsets Dropoff Notes.
     * A note to provide additional instructions about how to deliver the order.
     */
    public function unsetDropoffNotes(): void
    {
        $this->dropoffNotes = [];
    }

    /**
     * Returns Courier Provider Name.
     * The name of the courier provider.
     */
    public function getCourierProviderName(): ?string
    {
        if (count($this->courierProviderName) == 0) {
            return null;
        }
        return $this->courierProviderName['value'];
    }

    /**
     * Sets Courier Provider Name.
     * The name of the courier provider.
     *
     * @maps courier_provider_name
     */
    public function setCourierProviderName(?string $courierProviderName): void
    {
        $this->courierProviderName['value'] = $courierProviderName;
    }

    /**
     * Unsets Courier Provider Name.
     * The name of the courier provider.
     */
    public function unsetCourierProviderName(): void
    {
        $this->courierProviderName = [];
    }

    /**
     * Returns Courier Support Phone Number.
     * The support phone number of the courier.
     */
    public function getCourierSupportPhoneNumber(): ?string
    {
        if (count($this->courierSupportPhoneNumber) == 0) {
            return null;
        }
        return $this->courierSupportPhoneNumber['value'];
    }

    /**
     * Sets Courier Support Phone Number.
     * The support phone number of the courier.
     *
     * @maps courier_support_phone_number
     */
    public function setCourierSupportPhoneNumber(?string $courierSupportPhoneNumber): void
    {
        $this->courierSupportPhoneNumber['value'] = $courierSupportPhoneNumber;
    }

    /**
     * Unsets Courier Support Phone Number.
     * The support phone number of the courier.
     */
    public function unsetCourierSupportPhoneNumber(): void
    {
        $this->courierSupportPhoneNumber = [];
    }

    /**
     * Returns Square Delivery Id.
     * The identifier for the delivery created by Square.
     */
    public function getSquareDeliveryId(): ?string
    {
        if (count($this->squareDeliveryId) == 0) {
            return null;
        }
        return $this->squareDeliveryId['value'];
    }

    /**
     * Sets Square Delivery Id.
     * The identifier for the delivery created by Square.
     *
     * @maps square_delivery_id
     */
    public function setSquareDeliveryId(?string $squareDeliveryId): void
    {
        $this->squareDeliveryId['value'] = $squareDeliveryId;
    }

    /**
     * Unsets Square Delivery Id.
     * The identifier for the delivery created by Square.
     */
    public function unsetSquareDeliveryId(): void
    {
        $this->squareDeliveryId = [];
    }

    /**
     * Returns External Delivery Id.
     * The identifier for the delivery created by the third-party courier service.
     */
    public function getExternalDeliveryId(): ?string
    {
        if (count($this->externalDeliveryId) == 0) {
            return null;
        }
        return $this->externalDeliveryId['value'];
    }

    /**
     * Sets External Delivery Id.
     * The identifier for the delivery created by the third-party courier service.
     *
     * @maps external_delivery_id
     */
    public function setExternalDeliveryId(?string $externalDeliveryId): void
    {
        $this->externalDeliveryId['value'] = $externalDeliveryId;
    }

    /**
     * Unsets External Delivery Id.
     * The identifier for the delivery created by the third-party courier service.
     */
    public function unsetExternalDeliveryId(): void
    {
        $this->externalDeliveryId = [];
    }

    /**
     * Returns Managed Delivery.
     * The flag to indicate the delivery is managed by a third party (ie DoorDash), which means
     * we may not receive all recipient information for PII purposes.
     */
    public function getManagedDelivery(): ?bool
    {
        if (count($this->managedDelivery) == 0) {
            return null;
        }
        return $this->managedDelivery['value'];
    }

    /**
     * Sets Managed Delivery.
     * The flag to indicate the delivery is managed by a third party (ie DoorDash), which means
     * we may not receive all recipient information for PII purposes.
     *
     * @maps managed_delivery
     */
    public function setManagedDelivery(?bool $managedDelivery): void
    {
        $this->managedDelivery['value'] = $managedDelivery;
    }

    /**
     * Unsets Managed Delivery.
     * The flag to indicate the delivery is managed by a third party (ie DoorDash), which means
     * we may not receive all recipient information for PII purposes.
     */
    public function unsetManagedDelivery(): void
    {
        $this->managedDelivery = [];
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
            $json['recipient']                      = $this->recipient;
        }
        if (isset($this->scheduleType)) {
            $json['schedule_type']                  = $this->scheduleType;
        }
        if (isset($this->placedAt)) {
            $json['placed_at']                      = $this->placedAt;
        }
        if (!empty($this->deliverAt)) {
            $json['deliver_at']                     = $this->deliverAt['value'];
        }
        if (!empty($this->prepTimeDuration)) {
            $json['prep_time_duration']             = $this->prepTimeDuration['value'];
        }
        if (!empty($this->deliveryWindowDuration)) {
            $json['delivery_window_duration']       = $this->deliveryWindowDuration['value'];
        }
        if (!empty($this->note)) {
            $json['note']                           = $this->note['value'];
        }
        if (!empty($this->completedAt)) {
            $json['completed_at']                   = $this->completedAt['value'];
        }
        if (isset($this->inProgressAt)) {
            $json['in_progress_at']                 = $this->inProgressAt;
        }
        if (isset($this->rejectedAt)) {
            $json['rejected_at']                    = $this->rejectedAt;
        }
        if (isset($this->readyAt)) {
            $json['ready_at']                       = $this->readyAt;
        }
        if (isset($this->deliveredAt)) {
            $json['delivered_at']                   = $this->deliveredAt;
        }
        if (isset($this->canceledAt)) {
            $json['canceled_at']                    = $this->canceledAt;
        }
        if (!empty($this->cancelReason)) {
            $json['cancel_reason']                  = $this->cancelReason['value'];
        }
        if (!empty($this->courierPickupAt)) {
            $json['courier_pickup_at']              = $this->courierPickupAt['value'];
        }
        if (!empty($this->courierPickupWindowDuration)) {
            $json['courier_pickup_window_duration'] = $this->courierPickupWindowDuration['value'];
        }
        if (!empty($this->isNoContactDelivery)) {
            $json['is_no_contact_delivery']         = $this->isNoContactDelivery['value'];
        }
        if (!empty($this->dropoffNotes)) {
            $json['dropoff_notes']                  = $this->dropoffNotes['value'];
        }
        if (!empty($this->courierProviderName)) {
            $json['courier_provider_name']          = $this->courierProviderName['value'];
        }
        if (!empty($this->courierSupportPhoneNumber)) {
            $json['courier_support_phone_number']   = $this->courierSupportPhoneNumber['value'];
        }
        if (!empty($this->squareDeliveryId)) {
            $json['square_delivery_id']             = $this->squareDeliveryId['value'];
        }
        if (!empty($this->externalDeliveryId)) {
            $json['external_delivery_id']           = $this->externalDeliveryId['value'];
        }
        if (!empty($this->managedDelivery)) {
            $json['managed_delivery']               = $this->managedDelivery['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
