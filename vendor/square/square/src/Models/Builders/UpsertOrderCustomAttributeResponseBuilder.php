<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertOrderCustomAttributeResponse;

/**
 * Builder for model UpsertOrderCustomAttributeResponse
 *
 * @see UpsertOrderCustomAttributeResponse
 */
class UpsertOrderCustomAttributeResponseBuilder
{
    /**
     * @var UpsertOrderCustomAttributeResponse
     */
    private $instance;

    private function __construct(UpsertOrderCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert order custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpsertOrderCustomAttributeResponse());
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
     * Initializes a new upsert order custom attribute response object.
     */
    public function build(): UpsertOrderCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
