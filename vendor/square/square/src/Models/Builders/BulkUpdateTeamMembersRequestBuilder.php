<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpdateTeamMembersRequest;

/**
 * Builder for model BulkUpdateTeamMembersRequest
 *
 * @see BulkUpdateTeamMembersRequest
 */
class BulkUpdateTeamMembersRequestBuilder
{
    /**
     * @var BulkUpdateTeamMembersRequest
     */
    private $instance;

    private function __construct(BulkUpdateTeamMembersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk update team members request Builder object.
     */
    public static function init(array $teamMembers): self
    {
        return new self(new BulkUpdateTeamMembersRequest($teamMembers));
    }

    /**
     * Initializes a new bulk update team members request object.
     */
    public function build(): BulkUpdateTeamMembersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
