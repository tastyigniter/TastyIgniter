<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertBookingCustomAttributesResponse;

/**
 * Builder for model BulkUpsertBookingCustomAttributesResponse
 *
 * @see BulkUpsertBookingCustomAttributesResponse
 */
class BulkUpsertBookingCustomAttributesResponseBuilder
{
    /**
     * @var BulkUpsertBookingCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkUpsertBookingCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert booking custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpsertBookingCustomAttributesResponse());
    }

    /**
     * Sets values field.
     */
    public function values(?array $value): self
    {
        $this->instance->setValues($value);
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
     * Initializes a new bulk upsert booking custom attributes response object.
     */
    public function build(): BulkUpsertBookingCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
