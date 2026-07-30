<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Device;

/**
 * Builder for model Device
 *
 * @see Device
 */
class DeviceBuilder
{
    /**
     * @var Device
     */
    private $instance;

    private function __construct(Device $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new device Builder object.
     */
    public static function init(): self
    {
        return new self(new Device());
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
     * Initializes a new device object.
     */
    public function build(): Device
    {
        return CoreHelper::clone($this->instance);
    }
}
