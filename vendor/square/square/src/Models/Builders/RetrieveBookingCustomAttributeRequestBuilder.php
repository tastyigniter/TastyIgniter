<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveBookingCustomAttributeRequest;

/**
 * Builder for model RetrieveBookingCustomAttributeRequest
 *
 * @see RetrieveBookingCustomAttributeRequest
 */
class RetrieveBookingCustomAttributeRequestBuilder
{
    /**
     * @var RetrieveBookingCustomAttributeRequest
     */
    private $instance;

    private function __construct(RetrieveBookingCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve booking custom attribute request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBookingCustomAttributeRequest());
    }

    /**
     * Sets with definition field.
     */
    public function withDefinition(?bool $value): self
    {
        $this->instance->setWithDefinition($value);
        return $this;
    }

    /**
     * Unsets with definition field.
     */
    public function unsetWithDefinition(): self
    {
        $this->instance->unsetWithDefinition();
        return $this;
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
     * Initializes a new retrieve booking custom attribute request object.
     */
    public function build(): RetrieveBookingCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
