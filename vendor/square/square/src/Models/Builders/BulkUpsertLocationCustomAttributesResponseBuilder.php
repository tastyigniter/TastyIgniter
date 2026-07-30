<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertLocationCustomAttributesResponse;

/**
 * Builder for model BulkUpsertLocationCustomAttributesResponse
 *
 * @see BulkUpsertLocationCustomAttributesResponse
 */
class BulkUpsertLocationCustomAttributesResponseBuilder
{
    /**
     * @var BulkUpsertLocationCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkUpsertLocationCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert location custom attributes response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpsertLocationCustomAttributesResponse());
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
     * Initializes a new bulk upsert location custom attributes response object.
     */
    public function build(): BulkUpsertLocationCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
