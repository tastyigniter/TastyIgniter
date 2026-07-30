<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateOrderCustomAttributeDefinitionResponse;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateOrderCustomAttributeDefinitionResponse
 *
 * @see CreateOrderCustomAttributeDefinitionResponse
 */
class CreateOrderCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var CreateOrderCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(CreateOrderCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create order custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateOrderCustomAttributeDefinitionResponse());
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
     * Initializes a new create order custom attribute definition response object.
     */
    public function build(): CreateOrderCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
