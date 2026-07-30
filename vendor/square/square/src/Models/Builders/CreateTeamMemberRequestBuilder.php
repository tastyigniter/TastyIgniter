<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTeamMemberRequest;
use Square\Models\TeamMember;

/**
 * Builder for model CreateTeamMemberRequest
 *
 * @see CreateTeamMemberRequest
 */
class CreateTeamMemberRequestBuilder
{
    /**
     * @var CreateTeamMemberRequest
     */
    private $instance;

    private function __construct(CreateTeamMemberRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create team member request Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateTeamMemberRequest());
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
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
     * Initializes a new create team member request object.
     */
    public function build(): CreateTeamMemberRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
