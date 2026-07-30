<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchSubscriptionsFilter;
use Square\Models\SearchSubscriptionsQuery;

/**
 * Builder for model SearchSubscriptionsQuery
 *
 * @see SearchSubscriptionsQuery
 */
class SearchSubscriptionsQueryBuilder
{
    /**
     * @var SearchSubscriptionsQuery
     */
    private $instance;

    private function __construct(SearchSubscriptionsQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search subscriptions query Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchSubscriptionsQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?SearchSubscriptionsFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Initializes a new search subscriptions query object.
     */
    public function build(): SearchSubscriptionsQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
