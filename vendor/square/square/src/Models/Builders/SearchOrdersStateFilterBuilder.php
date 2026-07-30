<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersStateFilter;

/**
 * Builder for model SearchOrdersStateFilter
 *
 * @see SearchOrdersStateFilter
 */
class SearchOrdersStateFilterBuilder
{
    /**
     * @var SearchOrdersStateFilter
     */
    private $instance;

    private function __construct(SearchOrdersStateFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders state filter Builder object.
     */
    public static function init(array $states): self
    {
        return new self(new SearchOrdersStateFilter($states));
    }

    /**
     * Initializes a new search orders state filter object.
     */
    public function build(): SearchOrdersStateFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
