<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\JobAssignment;
use Square\Models\Money;

/**
 * Builder for model JobAssignment
 *
 * @see JobAssignment
 */
class JobAssignmentBuilder
{
    /**
     * @var JobAssignment
     */
    private $instance;

    private function __construct(JobAssignment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new job assignment Builder object.
     */
    public static function init(string $jobTitle, string $payType): self
    {
        return new self(new JobAssignment($jobTitle, $payType));
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
     * Sets annual rate field.
     */
    public function annualRate(?Money $value): self
    {
        $this->instance->setAnnualRate($value);
        return $this;
    }

    /**
     * Sets weekly hours field.
     */
    public function weeklyHours(?int $value): self
    {
        $this->instance->setWeeklyHours($value);
        return $this;
    }

    /**
     * Unsets weekly hours field.
     */
    public function unsetWeeklyHours(): self
    {
        $this->instance->unsetWeeklyHours();
        return $this;
    }

    /**
     * Initializes a new job assignment object.
     */
    public function build(): JobAssignment
    {
        return CoreHelper::clone($this->instance);
    }
}
