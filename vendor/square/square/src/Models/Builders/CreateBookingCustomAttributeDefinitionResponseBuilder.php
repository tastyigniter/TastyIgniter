<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateBookingCustomAttributeDefinitionResponse;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateBookingCustomAttributeDefinitionResponse
 *
 * @see CreateBookingCustomAttributeDefinitionResponse
 */
class CreateBookingCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var CreateBookingCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(CreateBookingCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create booking custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateBookingCustomAttributeDefinitionResponse());
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
     * Initializes a new create booking custom attribute definition response object.
     */
    public function build(): CreateBookingCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
