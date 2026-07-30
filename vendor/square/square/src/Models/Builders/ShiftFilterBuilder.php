<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ShiftFilter;
use Square\Models\ShiftWorkday;
use Square\Models\TimeRange;

/**
 * Builder for model ShiftFilter
 *
 * @see ShiftFilter
 */
class ShiftFilterBuilder
{
    /**
     * @var ShiftFilter
     */
    private $instance;

    private function __construct(ShiftFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new shift filter Builder object.
     */
    public static function init(): self
    {
        return new self(new ShiftFilter());
    }

    /**
     * Sets location ids field.
     */
    public function locationIds(?array $value): self
    {
        $this->instance->setLocationIds($value);
        return $this;
    }

    /**
     * Unsets location ids field.
     */
    public function unsetLocationIds(): self
    {
        $this->instance->unsetLocationIds();
        return $this;
    }

    /**
     * Sets employee ids field.
     */
    public function employeeIds(?array $value): self
    {
        $this->instance->setEmployeeIds($value);
        return $this;
    }

    /**
     * Unsets employee ids field.
     */
    public function unsetEmployeeIds(): self
    {
        $this->instance->unsetEmployeeIds();
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets start field.
     */
    public function start(?TimeRange $value): self
    {
        $this->instance->setStart($value);
        return $this;
    }

    /**
     * Sets end field.
     */
    public function end(?TimeRange $value): self
    {
        $this->instance->setEnd($value);
        return $this;
    }

    /**
     * Sets workday field.
     */
    public function workday(?ShiftWorkday $value): self
    {
        $this->instance->setWorkday($value);
        return $this;
    }

    /**
     * Sets team member ids field.
     */
    public function teamMemberIds(?array $value): self
    {
        $this->instance->setTeamMemberIds($value);
        return $this;
    }

    /**
     * Unsets team member ids field.
     */
    public function unsetTeamMemberIds(): self
    {
        $this->instance->unsetTeamMemberIds();
        return $this;
    }

    /**
     * Initializes a new shift filter object.
     */
    public function build(): ShiftFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
