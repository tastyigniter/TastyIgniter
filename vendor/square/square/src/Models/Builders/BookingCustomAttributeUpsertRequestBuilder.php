<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BookingCustomAttributeUpsertRequest;
use Square\Models\CustomAttribute;

/**
 * Builder for model BookingCustomAttributeUpsertRequest
 *
 * @see BookingCustomAttributeUpsertRequest
 */
class BookingCustomAttributeUpsertRequestBuilder
{
    /**
     * @var BookingCustomAttributeUpsertRequest
     */
    private $instance;

    private function __construct(BookingCustomAttributeUpsertRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new booking custom attribute upsert request Builder object.
     */
    public static function init(string $bookingId, CustomAttribute $customAttribute): self
    {
        return new self(new BookingCustomAttributeUpsertRequest($bookingId, $customAttribute));
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
     * Initializes a new booking custom attribute upsert request object.
     */
    public function build(): BookingCustomAttributeUpsertRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
