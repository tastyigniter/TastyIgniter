<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\UpdateLocationCustomAttributeDefinitionResponse;

/**
 * Builder for model UpdateLocationCustomAttributeDefinitionResponse
 *
 * @see UpdateLocationCustomAttributeDefinitionResponse
 */
class UpdateLocationCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var UpdateLocationCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(UpdateLocationCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update location custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateLocationCustomAttributeDefinitionResponse());
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
     * Initializes a new update location custom attribute definition response object.
     */
    public function build(): UpdateLocationCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
