<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DateRange;
use Square\Models\ShiftWorkday;

/**
 * Builder for model ShiftWorkday
 *
 * @see ShiftWorkday
 */
class ShiftWorkdayBuilder
{
    /**
     * @var ShiftWorkday
     */
    private $instance;

    private function __construct(ShiftWorkday $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new shift workday Builder object.
     */
    public static function init(): self
    {
        return new self(new ShiftWorkday());
    }

    /**
     * Sets date range field.
     */
    public function dateRange(?DateRange $value): self
    {
        $this->instance->setDateRange($value);
        return $this;
    }

    /**
     * Sets match shifts by field.
     */
    public function matchShiftsBy(?string $value): self
    {
        $this->instance->setMatchShiftsBy($value);
        return $this;
    }

    /**
     * Sets default timezone field.
     */
    public function defaultTimezone(?string $value): self
    {
        $this->instance->setDefaultTimezone($value);
        return $this;
    }

    /**
     * Unsets default timezone field.
     */
    public function unsetDefaultTimezone(): self
    {
        $this->instance->unsetDefaultTimezone();
        return $this;
    }

    /**
     * Initializes a new shift workday object.
     */
    public function build(): ShiftWorkday
    {
        return CoreHelper::clone($this->instance);
    }
}
