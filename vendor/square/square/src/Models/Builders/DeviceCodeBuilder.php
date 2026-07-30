<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeviceCode;

/**
 * Builder for model DeviceCode
 *
 * @see DeviceCode
 */
class DeviceCodeBuilder
{
    /**
     * @var DeviceCode
     */
    private $instance;

    private function __construct(DeviceCode $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new device code Builder object.
     */
    public static function init(): self
    {
        return new self(new DeviceCode());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets code field.
     */
    public function code(?string $value): self
    {
        $this->instance->setCode($value);
        return $this;
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
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets pair by field.
     */
    public function pairBy(?string $value): self
    {
        $this->instance->setPairBy($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets status changed at field.
     */
    public function statusChangedAt(?string $value): self
    {
        $this->instance->setStatusChangedAt($value);
        return $this;
    }

    /**
     * Sets paired at field.
     */
    public function pairedAt(?string $value): self
    {
        $this->instance->setPairedAt($value);
        return $this;
    }

    /**
     * Initializes a new device code object.
     */
    public function build(): DeviceCode
    {
        return CoreHelper::clone($this->instance);
    }
}
