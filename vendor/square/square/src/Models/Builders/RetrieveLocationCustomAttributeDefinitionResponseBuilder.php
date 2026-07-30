<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\RetrieveLocationCustomAttributeDefinitionResponse;

/**
 * Builder for model RetrieveLocationCustomAttributeDefinitionResponse
 *
 * @see RetrieveLocationCustomAttributeDefinitionResponse
 */
class RetrieveLocationCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var RetrieveLocationCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(RetrieveLocationCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve location custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLocationCustomAttributeDefinitionResponse());
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
     * Initializes a new retrieve location custom attribute definition response object.
     */
    public function build(): RetrieveLocationCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
