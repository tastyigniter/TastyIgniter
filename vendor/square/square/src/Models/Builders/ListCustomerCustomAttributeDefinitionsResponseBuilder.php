<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerCustomAttributeDefinitionsResponse;

/**
 * Builder for model ListCustomerCustomAttributeDefinitionsResponse
 *
 * @see ListCustomerCustomAttributeDefinitionsResponse
 */
class ListCustomerCustomAttributeDefinitionsResponseBuilder
{
    /**
     * @var ListCustomerCustomAttributeDefinitionsResponse
     */
    private $instance;

    private function __construct(ListCustomerCustomAttributeDefinitionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer custom attribute definitions response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerCustomAttributeDefinitionsResponse());
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
     * Initializes a new list customer custom attribute definitions response object.
     */
    public function build(): ListCustomerCustomAttributeDefinitionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
