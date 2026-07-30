<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttribute;
use Square\Models\UpsertBookingCustomAttributeRequest;

/**
 * Builder for model UpsertBookingCustomAttributeRequest
 *
 * @see UpsertBookingCustomAttributeRequest
 */
class UpsertBookingCustomAttributeRequestBuilder
{
    /**
     * @var UpsertBookingCustomAttributeRequest
     */
    private $instance;

    private function __construct(UpsertBookingCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert booking custom attribute request Builder object.
     */
    public static function init(CustomAttribute $customAttribute): self
    {
        return new self(new UpsertBookingCustomAttributeRequest($customAttribute));
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
     * Initializes a new upsert booking custom attribute request object.
     */
    public function build(): UpsertBookingCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
