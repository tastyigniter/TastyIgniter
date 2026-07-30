<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse;
use Square\Models\CustomAttribute;

/**
 * Builder for model BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse
 *
 * @see BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse
 */
class BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponseBuilder
{
    /**
     * @var BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse
     */
    private $instance;

    private function __construct(
        BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert location custom attributes response location custom attribute upsert
     * response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse());
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
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
     * Initializes a new bulk upsert location custom attributes response location custom attribute upsert
     * response object.
     */
    public function build(): BulkUpsertLocationCustomAttributesResponseLocationCustomAttributeUpsertResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
