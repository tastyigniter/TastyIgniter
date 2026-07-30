<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TeamMember;
use Square\Models\UpdateTeamMemberRequest;

/**
 * Builder for model UpdateTeamMemberRequest
 *
 * @see UpdateTeamMemberRequest
 */
class UpdateTeamMemberRequestBuilder
{
    /**
     * @var UpdateTeamMemberRequest
     */
    private $instance;

    private function __construct(UpdateTeamMemberRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update team member request Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateTeamMemberRequest());
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
     * Initializes a new update team member request object.
     */
    public function build(): UpdateTeamMemberRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
