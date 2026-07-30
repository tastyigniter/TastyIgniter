<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersFilter;
use Square\Models\SearchOrdersQuery;
use Square\Models\SearchOrdersSort;

/**
 * Builder for model SearchOrdersQuery
 *
 * @see SearchOrdersQuery
 */
class SearchOrdersQueryBuilder
{
    /**
     * @var SearchOrdersQuery
     */
    private $instance;

    private function __construct(SearchOrdersQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders query Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?SearchOrdersFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?SearchOrdersSort $value): self
    {
        $this->instance->setSort($value);
        return $this;
    }

    /**
     * Initializes a new search orders query object.
     */
    public function build(): SearchOrdersQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
