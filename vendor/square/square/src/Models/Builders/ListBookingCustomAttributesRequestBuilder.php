<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBookingCustomAttributesRequest;

/**
 * Builder for model ListBookingCustomAttributesRequest
 *
 * @see ListBookingCustomAttributesRequest
 */
class ListBookingCustomAttributesRequestBuilder
{
    /**
     * @var ListBookingCustomAttributesRequest
     */
    private $instance;

    private function __construct(ListBookingCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list booking custom attributes request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBookingCustomAttributesRequest());
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
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
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets with definitions field.
     */
    public function withDefinitions(?bool $value): self
    {
        $this->instance->setWithDefinitions($value);
        return $this;
    }

    /**
     * Unsets with definitions field.
     */
    public function unsetWithDefinitions(): self
    {
        $this->instance->unsetWithDefinitions();
        return $this;
    }

    /**
     * Initializes a new list booking custom attributes request object.
     */
    public function build(): ListBookingCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
