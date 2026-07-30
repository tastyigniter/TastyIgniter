<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\RetrieveBookingCustomAttributeDefinitionResponse;

/**
 * Builder for model RetrieveBookingCustomAttributeDefinitionResponse
 *
 * @see RetrieveBookingCustomAttributeDefinitionResponse
 */
class RetrieveBookingCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var RetrieveBookingCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(RetrieveBookingCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve booking custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBookingCustomAttributeDefinitionResponse());
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
     * Initializes a new retrieve booking custom attribute definition response object.
     */
    public function build(): RetrieveBookingCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
