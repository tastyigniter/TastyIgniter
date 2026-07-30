<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Contains the details necessary to fulfill a shipment order.
 */
class OrderFulfillmentShipmentDetails implements \JsonSerializable
{
    /**
     * @var OrderFulfillmentRecipient|null
     */
    private $recipient;

    /**
     * @var array
     */
    private $carrier = [];

    /**
     * @var array
     */
    private $shippingNote = [];

    /**
     * @var array
     */
    private $shippingType = [];

    /**
     * @var array
     */
    private $trackingNumber = [];

    /**
     * @var array
     */
    private $trackingUrl = [];

    /**
     * @var string|null
     */
    private $placedAt;

    /**
     * @var string|null
     */
    private $inProgressAt;

    /**
     * @var string|null
     */
    private $packagedAt;

    /**
     * @var array
     */
    private $expectedShippedAt = [];

    /**
     * @var string|null
     */
    private $shippedAt;

    /**
     * @var array
     */
    private $canceledAt = [];

    /**
     * @var array
     */
    private $cancelReason = [];

    /**
     * @var string|null
     */
    private $failedAt;

    /**
     * @var array
     */
    private $failureReason = [];

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
     * Returns Carrier.
     * The shipping carrier being used to ship this fulfillment (such as UPS, FedEx, or USPS).
     */
    public function getCarrier(): ?string
    {
        if (count($this->carrier) == 0) {
            return null;
        }
        return $this->carrier['value'];
    }

    /**
     * Sets Carrier.
     * The shipping carrier being used to ship this fulfillment (such as UPS, FedEx, or USPS).
     *
     * @maps carrier
     */
    public function setCarrier(?string $carrier): void
    {
        $this->carrier['value'] = $carrier;
    }

    /**
     * Unsets Carrier.
     * The shipping carrier being used to ship this fulfillment (such as UPS, FedEx, or USPS).
     */
    public function unsetCarrier(): void
    {
        $this->carrier = [];
    }

    /**
     * Returns Shipping Note.
     * A note with additional information for the shipping carrier.
     */
    public function getShippingNote(): ?string
    {
        if (count($this->shippingNote) == 0) {
            return null;
        }
        return $this->shippingNote['value'];
    }

    /**
     * Sets Shipping Note.
     * A note with additional information for the shipping carrier.
     *
     * @maps shipping_note
     */
    public function setShippingNote(?string $shippingNote): void
    {
        $this->shippingNote['value'] = $shippingNote;
    }

    /**
     * Unsets Shipping Note.
     * A note with additional information for the shipping carrier.
     */
    public function unsetShippingNote(): void
    {
        $this->shippingNote = [];
    }

    /**
     * Returns Shipping Type.
     * A description of the type of shipping product purchased from the carrier
     * (such as First Class, Priority, or Express).
     */
    public function getShippingType(): ?string
    {
        if (count($this->shippingType) == 0) {
            return null;
        }
        return $this->shippingType['value'];
    }

    /**
     * Sets Shipping Type.
     * A description of the type of shipping product purchased from the carrier
     * (such as First Class, Priority, or Express).
     *
     * @maps shipping_type
     */
    public function setShippingType(?string $shippingType): void
    {
        $this->shippingType['value'] = $shippingType;
    }

    /**
     * Unsets Shipping Type.
     * A description of the type of shipping product purchased from the carrier
     * (such as First Class, Priority, or Express).
     */
    public function unsetShippingType(): void
    {
        $this->shippingType = [];
    }

    /**
     * Returns Tracking Number.
     * The reference number provided by the carrier to track the shipment's progress.
     */
    public function getTrackingNumber(): ?string
    {
        if (count($this->trackingNumber) == 0) {
            return null;
        }
        return $this->trackingNumber['value'];
    }

    /**
     * Sets Tracking Number.
     * The reference number provided by the carrier to track the shipment's progress.
     *
     * @maps tracking_number
     */
    public function setTrackingNumber(?string $trackingNumber): void
    {
        $this->trackingNumber['value'] = $trackingNumber;
    }

    /**
     * Unsets Tracking Number.
     * The reference number provided by the carrier to track the shipment's progress.
     */
    public function unsetTrackingNumber(): void
    {
        $this->trackingNumber = [];
    }

    /**
     * Returns Tracking Url.
     * A link to the tracking webpage on the carrier's website.
     */
    public function getTrackingUrl(): ?string
    {
        if (count($this->trackingUrl) == 0) {
            return null;
        }
        return $this->trackingUrl['value'];
    }

    /**
     * Sets Tracking Url.
     * A link to the tracking webpage on the carrier's website.
     *
     * @maps tracking_url
     */
    public function setTrackingUrl(?string $trackingUrl): void
    {
        $this->trackingUrl['value'] = $trackingUrl;
    }

    /**
     * Unsets Tracking Url.
     * A link to the tracking webpage on the carrier's website.
     */
    public function unsetTrackingUrl(): void
    {
        $this->trackingUrl = [];
    }

    /**
     * Returns Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment was requested. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getPlacedAt(): ?string
    {
        return $this->placedAt;
    }

    /**
     * Sets Placed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment was requested. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps placed_at
     */
    public function setPlacedAt(?string $placedAt): void
    {
        $this->placedAt = $placedAt;
    }

    /**
     * Returns In Progress At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `RESERVED` state, which  indicates that
     * preparation
     * of this shipment has begun. The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:
     * 33.123Z").
     */
    public function getInProgressAt(): ?string
    {
        return $this->inProgressAt;
    }

    /**
     * Sets In Progress At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `RESERVED` state, which  indicates that
     * preparation
     * of this shipment has begun. The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:
     * 33.123Z").
     *
     * @maps in_progress_at
     */
    public function setInProgressAt(?string $inProgressAt): void
    {
        $this->inProgressAt = $inProgressAt;
    }

    /**
     * Returns Packaged At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `PREPARED` state, which indicates that the
     * fulfillment is packaged. The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.
     * 123Z").
     */
    public function getPackagedAt(): ?string
    {
        return $this->packagedAt;
    }

    /**
     * Sets Packaged At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `PREPARED` state, which indicates that the
     * fulfillment is packaged. The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.
     * 123Z").
     *
     * @maps packaged_at
     */
    public function setPackagedAt(?string $packagedAt): void
    {
        $this->packagedAt = $packagedAt;
    }

    /**
     * Returns Expected Shipped At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment is expected to be delivered to the shipping carrier.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getExpectedShippedAt(): ?string
    {
        if (count($this->expectedShippedAt) == 0) {
            return null;
        }
        return $this->expectedShippedAt['value'];
    }

    /**
     * Sets Expected Shipped At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment is expected to be delivered to the shipping carrier.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps expected_shipped_at
     */
    public function setExpectedShippedAt(?string $expectedShippedAt): void
    {
        $this->expectedShippedAt['value'] = $expectedShippedAt;
    }

    /**
     * Unsets Expected Shipped At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment is expected to be delivered to the shipping carrier.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetExpectedShippedAt(): void
    {
        $this->expectedShippedAt = [];
    }

    /**
     * Returns Shipped At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `COMPLETED` state, which indicates that
     * the fulfillment has been given to the shipping carrier. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getShippedAt(): ?string
    {
        return $this->shippedAt;
    }

    /**
     * Sets Shipped At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when this fulfillment was moved to the `COMPLETED` state, which indicates that
     * the fulfillment has been given to the shipping carrier. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps shipped_at
     */
    public function setShippedAt(?string $shippedAt): void
    {
        $this->shippedAt = $shippedAt;
    }

    /**
     * Returns Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating the shipment was canceled.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getCanceledAt(): ?string
    {
        if (count($this->canceledAt) == 0) {
            return null;
        }
        return $this->canceledAt['value'];
    }

    /**
     * Sets Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating the shipment was canceled.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps canceled_at
     */
    public function setCanceledAt(?string $canceledAt): void
    {
        $this->canceledAt['value'] = $canceledAt;
    }

    /**
     * Unsets Canceled At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating the shipment was canceled.
     * The timestamp must be in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function unsetCanceledAt(): void
    {
        $this->canceledAt = [];
    }

    /**
     * Returns Cancel Reason.
     * A description of why the shipment was canceled.
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
     * A description of why the shipment was canceled.
     *
     * @maps cancel_reason
     */
    public function setCancelReason(?string $cancelReason): void
    {
        $this->cancelReason['value'] = $cancelReason;
    }

    /**
     * Unsets Cancel Reason.
     * A description of why the shipment was canceled.
     */
    public function unsetCancelReason(): void
    {
        $this->cancelReason = [];
    }

    /**
     * Returns Failed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment failed to be completed. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getFailedAt(): ?string
    {
        return $this->failedAt;
    }

    /**
     * Sets Failed At.
     * The [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * indicating when the shipment failed to be completed. The timestamp must be in RFC 3339 format
     * (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps failed_at
     */
    public function setFailedAt(?string $failedAt): void
    {
        $this->failedAt = $failedAt;
    }

    /**
     * Returns Failure Reason.
     * A description of why the shipment failed to be completed.
     */
    public function getFailureReason(): ?string
    {
        if (count($this->failureReason) == 0) {
            return null;
        }
        return $this->failureReason['value'];
    }

    /**
     * Sets Failure Reason.
     * A description of why the shipment failed to be completed.
     *
     * @maps failure_reason
     */
    public function setFailureReason(?string $failureReason): void
    {
        $this->failureReason['value'] = $failureReason;
    }

    /**
     * Unsets Failure Reason.
     * A description of why the shipment failed to be completed.
     */
    public function unsetFailureReason(): void
    {
        $this->failureReason = [];
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
            $json['recipient']           = $this->recipient;
        }
        if (!empty($this->carrier)) {
            $json['carrier']             = $this->carrier['value'];
        }
        if (!empty($this->shippingNote)) {
            $json['shipping_note']       = $this->shippingNote['value'];
        }
        if (!empty($this->shippingType)) {
            $json['shipping_type']       = $this->shippingType['value'];
        }
        if (!empty($this->trackingNumber)) {
            $json['tracking_number']     = $this->trackingNumber['value'];
        }
        if (!empty($this->trackingUrl)) {
            $json['tracking_url']        = $this->trackingUrl['value'];
        }
        if (isset($this->placedAt)) {
            $json['placed_at']           = $this->placedAt;
        }
        if (isset($this->inProgressAt)) {
            $json['in_progress_at']      = $this->inProgressAt;
        }
        if (isset($this->packagedAt)) {
            $json['packaged_at']         = $this->packagedAt;
        }
        if (!empty($this->expectedShippedAt)) {
            $json['expected_shipped_at'] = $this->expectedShippedAt['value'];
        }
        if (isset($this->shippedAt)) {
            $json['shipped_at']          = $this->shippedAt;
        }
        if (!empty($this->canceledAt)) {
            $json['canceled_at']         = $this->canceledAt['value'];
        }
        if (!empty($this->cancelReason)) {
            $json['cancel_reason']       = $this->cancelReason['value'];
        }
        if (isset($this->failedAt)) {
            $json['failed_at']           = $this->failedAt;
        }
        if (!empty($this->failureReason)) {
            $json['failure_reason']      = $this->failureReason['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
