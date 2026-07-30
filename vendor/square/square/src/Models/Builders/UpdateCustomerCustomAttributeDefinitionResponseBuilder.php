<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\UpdateCustomerCustomAttributeDefinitionResponse;

/**
 * Builder for model UpdateCustomerCustomAttributeDefinitionResponse
 *
 * @see UpdateCustomerCustomAttributeDefinitionResponse
 */
class UpdateCustomerCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var UpdateCustomerCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(UpdateCustomerCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update customer custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateCustomerCustomAttributeDefinitionResponse());
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
     * Initializes a new update customer custom attribute definition response object.
     */
    public function build(): UpdateCustomerCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
