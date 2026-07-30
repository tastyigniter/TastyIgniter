<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BusinessHours;

/**
 * Builder for model BusinessHours
 *
 * @see BusinessHours
 */
class BusinessHoursBuilder
{
    /**
     * @var BusinessHours
     */
    private $instance;

    private function __construct(BusinessHours $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new business hours Builder object.
     */
    public static function init(): self
    {
        return new self(new BusinessHours());
    }

    /**
     * Sets periods field.
     */
    public function periods(?array $value): self
    {
        $this->instance->setPeriods($value);
        return $this;
    }

    /**
     * Unsets periods field.
     */
    public function unsetPeriods(): self
    {
        $this->instance->unsetPeriods();
        return $this;
    }

    /**
     * Initializes a new business hours object.
     */
    public function build(): BusinessHours
    {
        return CoreHelper::clone($this->instance);
    }
}
