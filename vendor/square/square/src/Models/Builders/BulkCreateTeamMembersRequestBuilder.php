<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkCreateTeamMembersRequest;

/**
 * Builder for model BulkCreateTeamMembersRequest
 *
 * @see BulkCreateTeamMembersRequest
 */
class BulkCreateTeamMembersRequestBuilder
{
    /**
     * @var BulkCreateTeamMembersRequest
     */
    private $instance;

    private function __construct(BulkCreateTeamMembersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk create team members request Builder object.
     */
    public static function init(array $teamMembers): self
    {
        return new self(new BulkCreateTeamMembersRequest($teamMembers));
    }

    /**
     * Initializes a new bulk create team members request object.
     */
    public function build(): BulkCreateTeamMembersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
