<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetTeamMemberWageResponse;
use Square\Models\TeamMemberWage;

/**
 * Builder for model GetTeamMemberWageResponse
 *
 * @see GetTeamMemberWageResponse
 */
class GetTeamMemberWageResponseBuilder
{
    /**
     * @var GetTeamMemberWageResponse
     */
    private $instance;

    private function __construct(GetTeamMemberWageResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get team member wage response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetTeamMemberWageResponse());
    }

    /**
     * Sets team member wage field.
     */
    public function teamMemberWage(?TeamMemberWage $value): self
    {
        $this->instance->setTeamMemberWage($value);
        return $this;
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new get team member wage response object.
     */
    public function build(): GetTeamMemberWageResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
