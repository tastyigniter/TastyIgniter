<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteBookingCustomAttributeDefinitionResponse;

/**
 * Builder for model DeleteBookingCustomAttributeDefinitionResponse
 *
 * @see DeleteBookingCustomAttributeDefinitionResponse
 */
class DeleteBookingCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var DeleteBookingCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(DeleteBookingCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete booking custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteBookingCustomAttributeDefinitionResponse());
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
     * Initializes a new delete booking custom attribute definition response object.
     */
    public function build(): DeleteBookingCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
