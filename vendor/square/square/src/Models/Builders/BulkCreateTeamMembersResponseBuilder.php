<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkCreateTeamMembersResponse;

/**
 * Builder for model BulkCreateTeamMembersResponse
 *
 * @see BulkCreateTeamMembersResponse
 */
class BulkCreateTeamMembersResponseBuilder
{
    /**
     * @var BulkCreateTeamMembersResponse
     */
    private $instance;

    private function __construct(BulkCreateTeamMembersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk create team members response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkCreateTeamMembersResponse());
    }

    /**
     * Sets team members field.
     */
    public function teamMembers(?array $value): self
    {
        $this->instance->setTeamMembers($value);
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
     * Initializes a new bulk create team members response object.
     */
    public function build(): BulkCreateTeamMembersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
