<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBookingCustomAttributeDefinitionsResponse;

/**
 * Builder for model ListBookingCustomAttributeDefinitionsResponse
 *
 * @see ListBookingCustomAttributeDefinitionsResponse
 */
class ListBookingCustomAttributeDefinitionsResponseBuilder
{
    /**
     * @var ListBookingCustomAttributeDefinitionsResponse
     */
    private $instance;

    private function __construct(ListBookingCustomAttributeDefinitionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list booking custom attribute definitions response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBookingCustomAttributeDefinitionsResponse());
    }

    /**
     * Sets custom attribute definitions field.
     */
    public function customAttributeDefinitions(?array $value): self
    {
        $this->instance->setCustomAttributeDefinitions($value);
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
     * Initializes a new list booking custom attribute definitions response object.
     */
    public function build(): ListBookingCustomAttributeDefinitionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
