<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertCustomerCustomAttributeResponse;

/**
 * Builder for model UpsertCustomerCustomAttributeResponse
 *
 * @see UpsertCustomerCustomAttributeResponse
 */
class UpsertCustomerCustomAttributeResponseBuilder
{
    /**
     * @var UpsertCustomerCustomAttributeResponse
     */
    private $instance;

    private function __construct(UpsertCustomerCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert customer custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpsertCustomerCustomAttributeResponse());
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
     * Initializes a new upsert customer custom attribute response object.
     */
    public function build(): UpsertCustomerCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
