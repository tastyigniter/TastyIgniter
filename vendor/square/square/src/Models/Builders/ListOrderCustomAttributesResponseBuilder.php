<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListOrderCustomAttributesResponse;

/**
 * Builder for model ListOrderCustomAttributesResponse
 *
 * @see ListOrderCustomAttributesResponse
 */
class ListOrderCustomAttributesResponseBuilder
{
    /**
     * @var ListOrderCustomAttributesResponse
     */
    private $instance;

    private function __construct(ListOrderCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list order custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListOrderCustomAttributesResponse());
    }

    /**
     * Sets custom attributes field.
     */
    public function customAttributes(?array $value): self
    {
        $this->instance->setCustomAttributes($value);
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
     * Initializes a new list order custom attributes response object.
     */
    public function build(): ListOrderCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
