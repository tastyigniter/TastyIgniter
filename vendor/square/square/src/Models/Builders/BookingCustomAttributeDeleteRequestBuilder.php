<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BookingCustomAttributeDeleteRequest;

/**
 * Builder for model BookingCustomAttributeDeleteRequest
 *
 * @see BookingCustomAttributeDeleteRequest
 */
class BookingCustomAttributeDeleteRequestBuilder
{
    /**
     * @var BookingCustomAttributeDeleteRequest
     */
    private $instance;

    private function __construct(BookingCustomAttributeDeleteRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new booking custom attribute delete request Builder object.
     */
    public static function init(string $bookingId, string $key): self
    {
        return new self(new BookingCustomAttributeDeleteRequest($bookingId, $key));
    }

    /**
     * Initializes a new booking custom attribute delete request object.
     */
    public function build(): BookingCustomAttributeDeleteRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
