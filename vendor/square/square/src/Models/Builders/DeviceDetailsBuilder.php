<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeviceDetails;

/**
 * Builder for model DeviceDetails
 *
 * @see DeviceDetails
 */
class DeviceDetailsBuilder
{
    /**
     * @var DeviceDetails
     */
    private $instance;

    private function __construct(DeviceDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new device details Builder object.
     */
    public static function init(): self
    {
        return new self(new DeviceDetails());
    }

    /**
     * Sets device id field.
     */
    public function deviceId(?string $value): self
    {
        $this->instance->setDeviceId($value);
        return $this;
    }

    /**
     * Unsets device id field.
     */
    public function unsetDeviceId(): self
    {
        $this->instance->unsetDeviceId();
        return $this;
    }

    /**
     * Sets device installation id field.
     */
    public function deviceInstallationId(?string $value): self
    {
        $this->instance->setDeviceInstallationId($value);
        return $this;
    }

    /**
     * Unsets device installation id field.
     */
    public function unsetDeviceInstallationId(): self
    {
        $this->instance->unsetDeviceInstallationId();
        return $this;
    }

    /**
     * Sets device name field.
     */
    public function deviceName(?string $value): self
    {
        $this->instance->setDeviceName($value);
        return $this;
    }

    /**
     * Unsets device name field.
     */
    public function unsetDeviceName(): self
    {
        $this->instance->unsetDeviceName();
        return $this;
    }

    /**
     * Initializes a new device details object.
     */
    public function build(): DeviceDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
