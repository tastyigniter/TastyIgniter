<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpdateTeamMembersResponse;

/**
 * Builder for model BulkUpdateTeamMembersResponse
 *
 * @see BulkUpdateTeamMembersResponse
 */
class BulkUpdateTeamMembersResponseBuilder
{
    /**
     * @var BulkUpdateTeamMembersResponse
     */
    private $instance;

    private function __construct(BulkUpdateTeamMembersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk update team members response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpdateTeamMembersResponse());
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
     * Initializes a new bulk update team members response object.
     */
    public function build(): BulkUpdateTeamMembersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
