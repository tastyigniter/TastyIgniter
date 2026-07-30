<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBookingCustomAttributesResponse;

/**
 * Builder for model ListBookingCustomAttributesResponse
 *
 * @see ListBookingCustomAttributesResponse
 */
class ListBookingCustomAttributesResponseBuilder
{
    /**
     * @var ListBookingCustomAttributesResponse
     */
    private $instance;

    private function __construct(ListBookingCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list booking custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBookingCustomAttributesResponse());
    }

    /**
     * Sets custom attributes field.
     */
    public function customAttributes(?array $value): self
    {
        $this->instance->setCustomAttributes($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new list booking custom attributes response object.
     */
    public function build(): ListBookingCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
