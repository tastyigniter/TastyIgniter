<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\EmployeeWage;
use Square\Models\Money;

/**
 * Builder for model EmployeeWage
 *
 * @see EmployeeWage
 */
class EmployeeWageBuilder
{
    /**
     * @var EmployeeWage
     */
    private $instance;

    private function __construct(EmployeeWage $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new employee wage Builder object.
     */
    public static function init(): self
    {
        return new self(new EmployeeWage());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets employee id field.
     */
    public function employeeId(?string $value): self
    {
        $this->instance->setEmployeeId($value);
        return $this;
    }

    /**
     * Unsets employee id field.
     */
    public function unsetEmployeeId(): self
    {
        $this->instance->unsetEmployeeId();
        return $this;
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
     * Initializes a new employee wage object.
     */
    public function build(): EmployeeWage
    {
        return CoreHelper::clone($this->instance);
    }
}
