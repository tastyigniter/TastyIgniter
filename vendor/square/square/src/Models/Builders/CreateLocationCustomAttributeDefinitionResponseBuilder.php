<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLocationCustomAttributeDefinitionResponse;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateLocationCustomAttributeDefinitionResponse
 *
 * @see CreateLocationCustomAttributeDefinitionResponse
 */
class CreateLocationCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var CreateLocationCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(CreateLocationCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create location custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateLocationCustomAttributeDefinitionResponse());
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
     * Initializes a new create location custom attribute definition response object.
     */
    public function build(): CreateLocationCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
