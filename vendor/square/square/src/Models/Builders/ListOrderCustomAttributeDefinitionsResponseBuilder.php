<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListOrderCustomAttributeDefinitionsResponse;

/**
 * Builder for model ListOrderCustomAttributeDefinitionsResponse
 *
 * @see ListOrderCustomAttributeDefinitionsResponse
 */
class ListOrderCustomAttributeDefinitionsResponseBuilder
{
    /**
     * @var ListOrderCustomAttributeDefinitionsResponse
     */
    private $instance;

    private function __construct(ListOrderCustomAttributeDefinitionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list order custom attribute definitions response Builder object.
     */
    public static function init(array $customAttributeDefinitions): self
    {
        return new self(new ListOrderCustomAttributeDefinitionsResponse($customAttributeDefinitions));
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
     * Initializes a new list order custom attribute definitions response object.
     */
    public function build(): ListOrderCustomAttributeDefinitionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
