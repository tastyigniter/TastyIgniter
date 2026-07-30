<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelBookingRequest;

/**
 * Builder for model CancelBookingRequest
 *
 * @see CancelBookingRequest
 */
class CancelBookingRequestBuilder
{
    /**
     * @var CancelBookingRequest
     */
    private $instance;

    private function __construct(CancelBookingRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel booking request Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelBookingRequest());
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
     * Sets booking version field.
     */
    public function bookingVersion(?int $value): self
    {
        $this->instance->setBookingVersion($value);
        return $this;
    }

    /**
     * Unsets booking version field.
     */
    public function unsetBookingVersion(): self
    {
        $this->instance->unsetBookingVersion();
        return $this;
    }

    /**
     * Initializes a new cancel booking request object.
     */
    public function build(): CancelBookingRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
