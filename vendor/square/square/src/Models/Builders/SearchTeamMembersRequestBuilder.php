<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTeamMembersQuery;
use Square\Models\SearchTeamMembersRequest;

/**
 * Builder for model SearchTeamMembersRequest
 *
 * @see SearchTeamMembersRequest
 */
class SearchTeamMembersRequestBuilder
{
    /**
     * @var SearchTeamMembersRequest
     */
    private $instance;

    private function __construct(SearchTeamMembersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search team members request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTeamMembersRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?SearchTeamMembersQuery $value): self
    {
        $this->instance->setQuery($value);
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
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
     * Initializes a new search team members request object.
     */
    public function build(): SearchTeamMembersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
