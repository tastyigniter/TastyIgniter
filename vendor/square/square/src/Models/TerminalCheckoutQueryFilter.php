<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class TerminalCheckoutQueryFilter implements \JsonSerializable
{
    /**
     * @var array
     */
    private $deviceId = [];

    /**
     * @var TimeRange|null
     */
    private $createdAt;

    /**
     * @var array
     */
    private $status = [];

    /**
     * Returns Device Id.
     * The `TerminalCheckout` objects associated with a specific device. If no device is specified, then
     * all
     * `TerminalCheckout` objects for the merchant are displayed.
     */
    public function getDeviceId(): ?string
    {
        if (count($this->deviceId) == 0) {
            return null;
        }
        return $this->deviceId['value'];
    }

    /**
     * Sets Device Id.
     * The `TerminalCheckout` objects associated with a specific device. If no device is specified, then
     * all
     * `TerminalCheckout` objects for the merchant are displayed.
     *
     * @maps device_id
     */
    public function setDeviceId(?string $deviceId): void
    {
        $this->deviceId['value'] = $deviceId;
    }

    /**
     * Unsets Device Id.
     * The `TerminalCheckout` objects associated with a specific device. If no device is specified, then
     * all
     * `TerminalCheckout` objects for the merchant are displayed.
     */
    public function unsetDeviceId(): void
    {
        $this->deviceId = [];
    }

    /**
     * Returns Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getCreatedAt(): ?TimeRange
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps created_at
     */
    public function setCreatedAt(?TimeRange $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Status.
     * Filtered results with the desired status of the `TerminalCheckout`.
     * Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, `COMPLETED`
     */
    public function getStatus(): ?string
    {
        if (count($this->status) == 0) {
            return null;
        }
        return $this->status['value'];
    }

    /**
     * Sets Status.
     * Filtered results with the desired status of the `TerminalCheckout`.
     * Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, `COMPLETED`
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status['value'] = $status;
    }

    /**
     * Unsets Status.
     * Filtered results with the desired status of the `TerminalCheckout`.
     * Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, `COMPLETED`
     */
    public function unsetStatus(): void
    {
        $this->status = [];
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
        if (!empty($this->deviceId)) {
            $json['device_id']  = $this->deviceId['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at'] = $this->createdAt;
        }
        if (!empty($this->status)) {
            $json['status']     = $this->status['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
