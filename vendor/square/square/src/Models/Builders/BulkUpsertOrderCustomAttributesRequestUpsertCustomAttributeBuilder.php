<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute;
use Square\Models\CustomAttribute;

/**
 * Builder for model BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute
 *
 * @see BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute
 */
class BulkUpsertOrderCustomAttributesRequestUpsertCustomAttributeBuilder
{
    /**
     * @var BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute
     */
    private $instance;

    private function __construct(BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert order custom attributes request upsert custom attribute Builder object.
     */
    public static function init(CustomAttribute $customAttribute, string $orderId): self
    {
        return new self(
            new BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute($customAttribute, $orderId)
        );
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
     * Initializes a new bulk upsert order custom attributes request upsert custom attribute object.
     */
    public function build(): BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute
    {
        return CoreHelper::clone($this->instance);
    }
}
