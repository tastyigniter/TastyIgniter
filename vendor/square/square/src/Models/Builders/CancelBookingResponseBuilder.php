<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Booking;
use Square\Models\CancelBookingResponse;

/**
 * Builder for model CancelBookingResponse
 *
 * @see CancelBookingResponse
 */
class CancelBookingResponseBuilder
{
    /**
     * @var CancelBookingResponse
     */
    private $instance;

    private function __construct(CancelBookingResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel booking response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelBookingResponse());
    }

    /**
     * Sets booking field.
     */
    public function booking(?Booking $value): self
    {
        $this->instance->setBooking($value);
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
     * Initializes a new cancel booking response object.
     */
    public function build(): CancelBookingResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
