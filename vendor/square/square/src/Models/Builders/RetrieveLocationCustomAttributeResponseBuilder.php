<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\RetrieveLocationCustomAttributeResponse;

/**
 * Builder for model RetrieveLocationCustomAttributeResponse
 *
 * @see RetrieveLocationCustomAttributeResponse
 */
class RetrieveLocationCustomAttributeResponseBuilder
{
    /**
     * @var RetrieveLocationCustomAttributeResponse
     */
    private $instance;

    private function __construct(RetrieveLocationCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve location custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLocationCustomAttributeResponse());
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
     * Initializes a new retrieve location custom attribute response object.
     */
    public function build(): RetrieveLocationCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
