<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BookingCustomAttributeUpsertResponse;
use Square\Models\CustomAttribute;

/**
 * Builder for model BookingCustomAttributeUpsertResponse
 *
 * @see BookingCustomAttributeUpsertResponse
 */
class BookingCustomAttributeUpsertResponseBuilder
{
    /**
     * @var BookingCustomAttributeUpsertResponse
     */
    private $instance;

    private function __construct(BookingCustomAttributeUpsertResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new booking custom attribute upsert response Builder object.
     */
    public static function init(): self
    {
        return new self(new BookingCustomAttributeUpsertResponse());
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
     * Sets custom attribute field.
     */
    public function customAttribute(?CustomAttribute $value): self
    {
        $this->instance->setCustomAttribute($value);
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
     * Initializes a new booking custom attribute upsert response object.
     */
    public function build(): BookingCustomAttributeUpsertResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
