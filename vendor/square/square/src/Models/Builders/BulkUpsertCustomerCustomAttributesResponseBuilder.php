<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertCustomerCustomAttributesResponse;

/**
 * Builder for model BulkUpsertCustomerCustomAttributesResponse
 *
 * @see BulkUpsertCustomerCustomAttributesResponse
 */
class BulkUpsertCustomerCustomAttributesResponseBuilder
{
    /**
     * @var BulkUpsertCustomerCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkUpsertCustomerCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert customer custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpsertCustomerCustomAttributesResponse());
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
     * Initializes a new bulk upsert customer custom attributes response object.
     */
    public function build(): BulkUpsertCustomerCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
