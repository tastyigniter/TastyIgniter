<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\RetrieveOrderCustomAttributeDefinitionResponse;

/**
 * Builder for model RetrieveOrderCustomAttributeDefinitionResponse
 *
 * @see RetrieveOrderCustomAttributeDefinitionResponse
 */
class RetrieveOrderCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var RetrieveOrderCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(RetrieveOrderCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve order custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveOrderCustomAttributeDefinitionResponse());
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
     * Initializes a new retrieve order custom attribute definition response object.
     */
    public function build(): RetrieveOrderCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
