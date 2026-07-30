<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\TeamMemberWage;

/**
 * Builder for model TeamMemberWage
 *
 * @see TeamMemberWage
 */
class TeamMemberWageBuilder
{
    /**
     * @var TeamMemberWage
     */
    private $instance;

    private function __construct(TeamMemberWage $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new team member wage Builder object.
     */
    public static function init(): self
    {
        return new self(new TeamMemberWage());
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
     * Initializes a new team member wage object.
     */
    public function build(): TeamMemberWage
    {
        return CoreHelper::clone($this->instance);
    }
}
