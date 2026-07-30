<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BusinessHoursPeriod;

/**
 * Builder for model BusinessHoursPeriod
 *
 * @see BusinessHoursPeriod
 */
class BusinessHoursPeriodBuilder
{
    /**
     * @var BusinessHoursPeriod
     */
    private $instance;

    private function __construct(BusinessHoursPeriod $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new business hours period Builder object.
     */
    public static function init(): self
    {
        return new self(new BusinessHoursPeriod());
    }

    /**
     * Sets day of week field.
     */
    public function dayOfWeek(?string $value): self
    {
        $this->instance->setDayOfWeek($value);
        return $this;
    }

    /**
     * Sets start local time field.
     */
    public function startLocalTime(?string $value): self
    {
        $this->instance->setStartLocalTime($value);
        return $this;
    }

    /**
     * Unsets start local time field.
     */
    public function unsetStartLocalTime(): self
    {
        $this->instance->unsetStartLocalTime();
        return $this;
    }

    /**
     * Sets end local time field.
     */
    public function endLocalTime(?string $value): self
    {
        $this->instance->setEndLocalTime($value);
        return $this;
    }

    /**
     * Unsets end local time field.
     */
    public function unsetEndLocalTime(): self
    {
        $this->instance->unsetEndLocalTime();
        return $this;
    }

    /**
     * Initializes a new business hours period object.
     */
    public function build(): BusinessHoursPeriod
    {
        return CoreHelper::clone($this->instance);
    }
}
