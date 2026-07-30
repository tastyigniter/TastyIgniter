<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTeamMembersFilter;
use Square\Models\SearchTeamMembersQuery;

/**
 * Builder for model SearchTeamMembersQuery
 *
 * @see SearchTeamMembersQuery
 */
class SearchTeamMembersQueryBuilder
{
    /**
     * @var SearchTeamMembersQuery
     */
    private $instance;

    private function __construct(SearchTeamMembersQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search team members query Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTeamMembersQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?SearchTeamMembersFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Initializes a new search team members query object.
     */
    public function build(): SearchTeamMembersQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
