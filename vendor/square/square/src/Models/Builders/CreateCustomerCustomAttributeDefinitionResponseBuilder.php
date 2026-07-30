<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateCustomerCustomAttributeDefinitionResponse;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateCustomerCustomAttributeDefinitionResponse
 *
 * @see CreateCustomerCustomAttributeDefinitionResponse
 */
class CreateCustomerCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var CreateCustomerCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(CreateCustomerCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCustomerCustomAttributeDefinitionResponse());
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
     * Initializes a new create customer custom attribute definition response object.
     */
    public function build(): CreateCustomerCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
