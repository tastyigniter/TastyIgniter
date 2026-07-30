<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest;
use Square\Models\CustomAttribute;

/**
 * Builder for model BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest
 *
 * @see BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest
 */
class BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequestBuilder
{
    /**
     * @var BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest
     */
    private $instance;

    private function __construct(
        BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert customer custom attributes request customer custom attribute upsert
     * request Builder object.
     */
    public static function init(string $customerId, CustomAttribute $customAttribute): self
    {
        return new self(new BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest(
            $customerId,
            $customAttribute
        ));
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Unsets idempotency key field.
     */
    public function unsetIdempotencyKey(): self
    {
        $this->instance->unsetIdempotencyKey();
        return $this;
    }

    /**
     * Initializes a new bulk upsert customer custom attributes request customer custom attribute upsert
     * request object.
     */
    public function build(): BulkUpsertCustomerCustomAttributesRequestCustomerCustomAttributeUpsertRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
