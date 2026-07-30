<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListLocationCustomAttributeDefinitionsResponse;

/**
 * Builder for model ListLocationCustomAttributeDefinitionsResponse
 *
 * @see ListLocationCustomAttributeDefinitionsResponse
 */
class ListLocationCustomAttributeDefinitionsResponseBuilder
{
    /**
     * @var ListLocationCustomAttributeDefinitionsResponse
     */
    private $instance;

    private function __construct(ListLocationCustomAttributeDefinitionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list location custom attribute definitions response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListLocationCustomAttributeDefinitionsResponse());
    }

    /**
     * Sets custom attribute definitions field.
     */
    public function customAttributeDefinitions(?array $value): self
    {
        $this->instance->setCustomAttributeDefinitions($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
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
     * Initializes a new list location custom attribute definitions response object.
     */
    public function build(): ListLocationCustomAttributeDefinitionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
