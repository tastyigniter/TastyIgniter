<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Availability;

/**
 * Builder for model Availability
 *
 * @see Availability
 */
class AvailabilityBuilder
{
    /**
     * @var Availability
     */
    private $instance;

    private function __construct(Availability $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new availability Builder object.
     */
    public static function init(): self
    {
        return new self(new Availability());
    }

    /**
     * Sets start at field.
     */
    public function startAt(?string $value): self
    {
        $this->instance->setStartAt($value);
        return $this;
    }

    /**
     * Unsets start at field.
     */
    public function unsetStartAt(): self
    {
        $this->instance->unsetStartAt();
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
     * Sets appointment segments field.
     */
    public function appointmentSegments(?array $value): self
    {
        $this->instance->setAppointmentSegments($value);
        return $this;
    }

    /**
     * Unsets appointment segments field.
     */
    public function unsetAppointmentSegments(): self
    {
        $this->instance->unsetAppointmentSegments();
        return $this;
    }

    /**
     * Initializes a new availability object.
     */
    public function build(): Availability
    {
        return CoreHelper::clone($this->instance);
    }
}
