<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\RetrieveCustomerCustomAttributeResponse;

/**
 * Builder for model RetrieveCustomerCustomAttributeResponse
 *
 * @see RetrieveCustomerCustomAttributeResponse
 */
class RetrieveCustomerCustomAttributeResponseBuilder
{
    /**
     * @var RetrieveCustomerCustomAttributeResponse
     */
    private $instance;

    private function __construct(RetrieveCustomerCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve customer custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCustomerCustomAttributeResponse());
    }

    /**
     * Sets custom attribute field.
     */
    public function customAttribute(?CustomAttribute $value): self
    {
        $this->instance->setCustomAttribute($value);
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
     * Initializes a new retrieve customer custom attribute response object.
     */
    public function build(): RetrieveCustomerCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
