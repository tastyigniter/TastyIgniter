<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateDeviceCodeResponse;
use Square\Models\DeviceCode;

/**
 * Builder for model CreateDeviceCodeResponse
 *
 * @see CreateDeviceCodeResponse
 */
class CreateDeviceCodeResponseBuilder
{
    /**
     * @var CreateDeviceCodeResponse
     */
    private $instance;

    private function __construct(CreateDeviceCodeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create device code response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateDeviceCodeResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets device code field.
     */
    public function deviceCode(?DeviceCode $value): self
    {
        $this->instance->setDeviceCode($value);
        return $this;
    }

    /**
     * Initializes a new create device code response object.
     */
    public function build(): CreateDeviceCodeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
