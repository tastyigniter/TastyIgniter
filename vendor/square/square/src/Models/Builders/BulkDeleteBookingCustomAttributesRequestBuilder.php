<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteBookingCustomAttributesRequest;

/**
 * Builder for model BulkDeleteBookingCustomAttributesRequest
 *
 * @see BulkDeleteBookingCustomAttributesRequest
 */
class BulkDeleteBookingCustomAttributesRequestBuilder
{
    /**
     * @var BulkDeleteBookingCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkDeleteBookingCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete booking custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkDeleteBookingCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk delete booking custom attributes request object.
     */
    public function build(): BulkDeleteBookingCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
