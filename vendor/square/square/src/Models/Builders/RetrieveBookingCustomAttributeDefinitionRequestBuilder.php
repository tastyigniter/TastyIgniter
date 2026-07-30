<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveBookingCustomAttributeDefinitionRequest;

/**
 * Builder for model RetrieveBookingCustomAttributeDefinitionRequest
 *
 * @see RetrieveBookingCustomAttributeDefinitionRequest
 */
class RetrieveBookingCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var RetrieveBookingCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(RetrieveBookingCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve booking custom attribute definition request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBookingCustomAttributeDefinitionRequest());
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Initializes a new retrieve booking custom attribute definition request object.
     */
    public function build(): RetrieveBookingCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
