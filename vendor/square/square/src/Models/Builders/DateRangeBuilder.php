<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DateRange;

/**
 * Builder for model DateRange
 *
 * @see DateRange
 */
class DateRangeBuilder
{
    /**
     * @var DateRange
     */
    private $instance;

    private function __construct(DateRange $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new date range Builder object.
     */
    public static function init(): self
    {
        return new self(new DateRange());
    }

    /**
     * Sets start date field.
     */
    public function startDate(?string $value): self
    {
        $this->instance->setStartDate($value);
        return $this;
    }

    /**
     * Unsets start date field.
     */
    public function unsetStartDate(): self
    {
        $this->instance->unsetStartDate();
        return $this;
    }

    /**
     * Sets end date field.
     */
    public function endDate(?string $value): self
    {
        $this->instance->setEndDate($value);
        return $this;
    }

    /**
     * Unsets end date field.
     */
    public function unsetEndDate(): self
    {
        $this->instance->unsetEndDate();
        return $this;
    }

    /**
     * Initializes a new date range object.
     */
    public function build(): DateRange
    {
        return CoreHelper::clone($this->instance);
    }
}
