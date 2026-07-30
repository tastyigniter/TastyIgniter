<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListDeviceCodesResponse;

/**
 * Builder for model ListDeviceCodesResponse
 *
 * @see ListDeviceCodesResponse
 */
class ListDeviceCodesResponseBuilder
{
    /**
     * @var ListDeviceCodesResponse
     */
    private $instance;

    private function __construct(ListDeviceCodesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list device codes response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListDeviceCodesResponse());
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
     * Sets device codes field.
     */
    public function deviceCodes(?array $value): self
    {
        $this->instance->setDeviceCodes($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list device codes response object.
     */
    public function build(): ListDeviceCodesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
