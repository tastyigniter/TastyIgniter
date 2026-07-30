<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Booking;
use Square\Models\RetrieveBookingResponse;

/**
 * Builder for model RetrieveBookingResponse
 *
 * @see RetrieveBookingResponse
 */
class RetrieveBookingResponseBuilder
{
    /**
     * @var RetrieveBookingResponse
     */
    private $instance;

    private function __construct(RetrieveBookingResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve booking response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBookingResponse());
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
     * Initializes a new retrieve booking response object.
     */
    public function build(): RetrieveBookingResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
