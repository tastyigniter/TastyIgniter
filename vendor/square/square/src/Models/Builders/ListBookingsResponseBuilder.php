<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBookingsResponse;

/**
 * Builder for model ListBookingsResponse
 *
 * @see ListBookingsResponse
 */
class ListBookingsResponseBuilder
{
    /**
     * @var ListBookingsResponse
     */
    private $instance;

    private function __construct(ListBookingsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list bookings response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBookingsResponse());
    }

    /**
     * Sets bookings field.
     */
    public function bookings(?array $value): self
    {
        $this->instance->setBookings($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
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
     * Initializes a new list bookings response object.
     */
    public function build(): ListBookingsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
