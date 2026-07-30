<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Booking;
use Square\Models\UpdateBookingRequest;

/**
 * Builder for model UpdateBookingRequest
 *
 * @see UpdateBookingRequest
 */
class UpdateBookingRequestBuilder
{
    /**
     * @var UpdateBookingRequest
     */
    private $instance;

    private function __construct(UpdateBookingRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update booking request Builder object.
     */
    public static function init(Booking $booking): self
    {
        return new self(new UpdateBookingRequest($booking));
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
     * Initializes a new update booking request object.
     */
    public function build(): UpdateBookingRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
