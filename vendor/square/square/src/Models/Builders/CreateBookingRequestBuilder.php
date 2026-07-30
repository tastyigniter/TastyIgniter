<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Booking;
use Square\Models\CreateBookingRequest;

/**
 * Builder for model CreateBookingRequest
 *
 * @see CreateBookingRequest
 */
class CreateBookingRequestBuilder
{
    /**
     * @var CreateBookingRequest
     */
    private $instance;

    private function __construct(CreateBookingRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create booking request Builder object.
     */
    public static function init(Booking $booking): self
    {
        return new self(new CreateBookingRequest($booking));
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
     * Initializes a new create booking request object.
     */
    public function build(): CreateBookingRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
