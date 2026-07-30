<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest;
use Square\Models\CustomAttribute;

/**
 * Builder for model BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest
 *
 * @see BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest
 */
class BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequestBuilder
{
    /**
     * @var BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest
     */
    private $instance;

    private function __construct(
        BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert location custom attributes request location custom attribute upsert
     * request Builder object.
     */
    public static function init(string $locationId, CustomAttribute $customAttribute): self
    {
        return new self(new BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest(
            $locationId,
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
     * Initializes a new bulk upsert location custom attributes request location custom attribute upsert
     * request object.
     */
    public function build(): BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
