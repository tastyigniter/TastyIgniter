<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerCustomAttributesResponse;

/**
 * Builder for model ListCustomerCustomAttributesResponse
 *
 * @see ListCustomerCustomAttributesResponse
 */
class ListCustomerCustomAttributesResponseBuilder
{
    /**
     * @var ListCustomerCustomAttributesResponse
     */
    private $instance;

    private function __construct(ListCustomerCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerCustomAttributesResponse());
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
     * Initializes a new list customer custom attributes response object.
     */
    public function build(): ListCustomerCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
