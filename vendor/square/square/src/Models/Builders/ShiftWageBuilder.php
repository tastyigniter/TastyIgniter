<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\ShiftWage;

/**
 * Builder for model ShiftWage
 *
 * @see ShiftWage
 */
class ShiftWageBuilder
{
    /**
     * @var ShiftWage
     */
    private $instance;

    private function __construct(ShiftWage $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new shift wage Builder object.
     */
    public static function init(): self
    {
        return new self(new ShiftWage());
    }

    /**
     * Sets title field.
     */
    public function title(?string $value): self
    {
        $this->instance->setTitle($value);
        return $this;
    }

    /**
     * Unsets title field.
     */
    public function unsetTitle(): self
    {
        $this->instance->unsetTitle();
        return $this;
    }

    /**
     * Sets hourly rate field.
     */
    public function hourlyRate(?Money $value): self
    {
        $this->instance->setHourlyRate($value);
        return $this;
    }

    /**
     * Initializes a new shift wage object.
     */
    public function build(): ShiftWage
    {
        return CoreHelper::clone($this->instance);
    }
}
