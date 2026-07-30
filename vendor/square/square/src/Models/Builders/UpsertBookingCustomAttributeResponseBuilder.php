<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertBookingCustomAttributeResponse;

/**
 * Builder for model UpsertBookingCustomAttributeResponse
 *
 * @see UpsertBookingCustomAttributeResponse
 */
class UpsertBookingCustomAttributeResponseBuilder
{
    /**
     * @var UpsertBookingCustomAttributeResponse
     */
    private $instance;

    private function __construct(UpsertBookingCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert booking custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpsertBookingCustomAttributeResponse());
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
     * Initializes a new upsert booking custom attribute response object.
     */
    public function build(): UpsertBookingCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
