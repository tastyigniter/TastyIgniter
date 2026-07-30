<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTeamMembersResponse;

/**
 * Builder for model SearchTeamMembersResponse
 *
 * @see SearchTeamMembersResponse
 */
class SearchTeamMembersResponseBuilder
{
    /**
     * @var SearchTeamMembersResponse
     */
    private $instance;

    private function __construct(SearchTeamMembersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search team members response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTeamMembersResponse());
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
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
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
     * Initializes a new search team members response object.
     */
    public function build(): SearchTeamMembersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
