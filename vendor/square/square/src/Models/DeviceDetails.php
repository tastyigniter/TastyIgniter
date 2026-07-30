<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Details about the device that took the payment.
 */
class DeviceDetails implements \JsonSerializable
{
    /**
     * @var array
     */
    private $deviceId = [];

    /**
     * @var array
     */
    private $deviceInstallationId = [];

    /**
     * @var array
     */
    private $deviceName = [];

    /**
     * Returns Device Id.
     * The Square-issued ID of the device.
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
     * The Square-issued ID of the device.
     *
     * @maps device_id
     */
    public function setDeviceId(?string $deviceId): void
    {
        $this->deviceId['value'] = $deviceId;
    }

    /**
     * Unsets Device Id.
     * The Square-issued ID of the device.
     */
    public function unsetDeviceId(): void
    {
        $this->deviceId = [];
    }

    /**
     * Returns Device Installation Id.
     * The Square-issued installation ID for the device.
     */
    public function getDeviceInstallationId(): ?string
    {
        if (count($this->deviceInstallationId) == 0) {
            return null;
        }
        return $this->deviceInstallationId['value'];
    }

    /**
     * Sets Device Installation Id.
     * The Square-issued installation ID for the device.
     *
     * @maps device_installation_id
     */
    public function setDeviceInstallationId(?string $deviceInstallationId): void
    {
        $this->deviceInstallationId['value'] = $deviceInstallationId;
    }

    /**
     * Unsets Device Installation Id.
     * The Square-issued installation ID for the device.
     */
    public function unsetDeviceInstallationId(): void
    {
        $this->deviceInstallationId = [];
    }

    /**
     * Returns Device Name.
     * The name of the device set by the seller.
     */
    public function getDeviceName(): ?string
    {
        if (count($this->deviceName) == 0) {
            return null;
        }
        return $this->deviceName['value'];
    }

    /**
     * Sets Device Name.
     * The name of the device set by the seller.
     *
     * @maps device_name
     */
    public function setDeviceName(?string $deviceName): void
    {
        $this->deviceName['value'] = $deviceName;
    }

    /**
     * Unsets Device Name.
     * The name of the device set by the seller.
     */
    public function unsetDeviceName(): void
    {
        $this->deviceName = [];
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
            $json['device_id']              = $this->deviceId['value'];
        }
        if (!empty($this->deviceInstallationId)) {
            $json['device_installation_id'] = $this->deviceInstallationId['value'];
        }
        if (!empty($this->deviceName)) {
            $json['device_name']            = $this->deviceName['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
