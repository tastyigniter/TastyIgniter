<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTeamMemberResponse;
use Square\Models\TeamMember;

/**
 * Builder for model CreateTeamMemberResponse
 *
 * @see CreateTeamMemberResponse
 */
class CreateTeamMemberResponseBuilder
{
    /**
     * @var CreateTeamMemberResponse
     */
    private $instance;

    private function __construct(CreateTeamMemberResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create team member response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateTeamMemberResponse());
    }

    /**
     * Sets team member field.
     */
    public function teamMember(?TeamMember $value): self
    {
        $this->instance->setTeamMember($value);
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
     * Initializes a new create team member response object.
     */
    public function build(): CreateTeamMemberResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
