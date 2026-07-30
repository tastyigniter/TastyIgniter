<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBookingsRequest;

/**
 * Builder for model ListBookingsRequest
 *
 * @see ListBookingsRequest
 */
class ListBookingsRequestBuilder
{
    /**
     * @var ListBookingsRequest
     */
    private $instance;

    private function __construct(ListBookingsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list bookings request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBookingsRequest());
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
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
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Unsets team member id field.
     */
    public function unsetTeamMemberId(): self
    {
        $this->instance->unsetTeamMemberId();
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets start at min field.
     */
    public function startAtMin(?string $value): self
    {
        $this->instance->setStartAtMin($value);
        return $this;
    }

    /**
     * Unsets start at min field.
     */
    public function unsetStartAtMin(): self
    {
        $this->instance->unsetStartAtMin();
        return $this;
    }

    /**
     * Sets start at max field.
     */
    public function startAtMax(?string $value): self
    {
        $this->instance->setStartAtMax($value);
        return $this;
    }

    /**
     * Unsets start at max field.
     */
    public function unsetStartAtMax(): self
    {
        $this->instance->unsetStartAtMax();
        return $this;
    }

    /**
     * Initializes a new list bookings request object.
     */
    public function build(): ListBookingsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
