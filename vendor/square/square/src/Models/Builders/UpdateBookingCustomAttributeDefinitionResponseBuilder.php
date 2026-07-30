<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\UpdateBookingCustomAttributeDefinitionResponse;

/**
 * Builder for model UpdateBookingCustomAttributeDefinitionResponse
 *
 * @see UpdateBookingCustomAttributeDefinitionResponse
 */
class UpdateBookingCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var UpdateBookingCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(UpdateBookingCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update booking custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateBookingCustomAttributeDefinitionResponse());
    }

    /**
     * Sets custom attribute definition field.
     */
    public function customAttributeDefinition(?CustomAttributeDefinition $value): self
    {
        $this->instance->setCustomAttributeDefinition($value);
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
     * Initializes a new update booking custom attribute definition response object.
     */
    public function build(): UpdateBookingCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
