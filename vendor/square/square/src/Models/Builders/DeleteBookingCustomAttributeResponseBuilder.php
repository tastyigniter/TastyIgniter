<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteBookingCustomAttributeResponse;

/**
 * Builder for model DeleteBookingCustomAttributeResponse
 *
 * @see DeleteBookingCustomAttributeResponse
 */
class DeleteBookingCustomAttributeResponseBuilder
{
    /**
     * @var DeleteBookingCustomAttributeResponse
     */
    private $instance;

    private function __construct(DeleteBookingCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete booking custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteBookingCustomAttributeResponse());
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
     * Initializes a new delete booking custom attribute response object.
     */
    public function build(): DeleteBookingCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
