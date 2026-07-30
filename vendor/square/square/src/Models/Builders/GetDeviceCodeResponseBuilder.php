<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeviceCode;
use Square\Models\GetDeviceCodeResponse;

/**
 * Builder for model GetDeviceCodeResponse
 *
 * @see GetDeviceCodeResponse
 */
class GetDeviceCodeResponseBuilder
{
    /**
     * @var GetDeviceCodeResponse
     */
    private $instance;

    private function __construct(GetDeviceCodeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get device code response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetDeviceCodeResponse());
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
     * Initializes a new get device code response object.
     */
    public function build(): GetDeviceCodeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
