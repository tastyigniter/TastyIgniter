<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse;
use Square\Models\CustomAttribute;

/**
 * Builder for model BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse
 *
 * @see BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse
 */
class BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponseBuilder
{
    /**
     * @var BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse
     */
    private $instance;

    private function __construct(
        BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert customer custom attributes response customer custom attribute upsert
     * response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse());
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
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
     * Initializes a new bulk upsert customer custom attributes response customer custom attribute upsert
     * response object.
     */
    public function build(): BulkUpsertCustomerCustomAttributesResponseCustomerCustomAttributeUpsertResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
