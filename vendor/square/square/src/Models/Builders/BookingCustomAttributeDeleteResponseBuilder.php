<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BookingCustomAttributeDeleteResponse;

/**
 * Builder for model BookingCustomAttributeDeleteResponse
 *
 * @see BookingCustomAttributeDeleteResponse
 */
class BookingCustomAttributeDeleteResponseBuilder
{
    /**
     * @var BookingCustomAttributeDeleteResponse
     */
    private $instance;

    private function __construct(BookingCustomAttributeDeleteResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new booking custom attribute delete response Builder object.
     */
    public static function init(): self
    {
        return new self(new BookingCustomAttributeDeleteResponse());
    }

    /**
     * Sets booking id field.
     */
    public function bookingId(?string $value): self
    {
        $this->instance->setBookingId($value);
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
     * Initializes a new booking custom attribute delete response object.
     */
    public function build(): BookingCustomAttributeDeleteResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
