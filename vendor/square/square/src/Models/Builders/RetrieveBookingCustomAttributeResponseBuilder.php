<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\RetrieveBookingCustomAttributeResponse;

/**
 * Builder for model RetrieveBookingCustomAttributeResponse
 *
 * @see RetrieveBookingCustomAttributeResponse
 */
class RetrieveBookingCustomAttributeResponseBuilder
{
    /**
     * @var RetrieveBookingCustomAttributeResponse
     */
    private $instance;

    private function __construct(RetrieveBookingCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve booking custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBookingCustomAttributeResponse());
    }

    /**
     * Sets custom attribute field.
     */
    public function customAttribute(?CustomAttribute $value): self
    {
        $this->instance->setCustomAttribute($value);
        return $this;
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
     * Initializes a new retrieve booking custom attribute response object.
     */
    public function build(): RetrieveBookingCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
