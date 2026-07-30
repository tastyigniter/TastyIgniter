<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveTeamMemberResponse;
use Square\Models\TeamMember;

/**
 * Builder for model RetrieveTeamMemberResponse
 *
 * @see RetrieveTeamMemberResponse
 */
class RetrieveTeamMemberResponseBuilder
{
    /**
     * @var RetrieveTeamMemberResponse
     */
    private $instance;

    private function __construct(RetrieveTeamMemberResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve team member response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveTeamMemberResponse());
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
     * Initializes a new retrieve team member response object.
     */
    public function build(): RetrieveTeamMemberResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
