<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersSort;

/**
 * Builder for model SearchOrdersSort
 *
 * @see SearchOrdersSort
 */
class SearchOrdersSortBuilder
{
    /**
     * @var SearchOrdersSort
     */
    private $instance;

    private function __construct(SearchOrdersSort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders sort Builder object.
     */
    public static function init(string $sortField): self
    {
        return new self(new SearchOrdersSort($sortField));
    }

    /**
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
        return $this;
    }

    /**
     * Initializes a new search orders sort object.
     */
    public function build(): SearchOrdersSort
    {
        return CoreHelper::clone($this->instance);
    }
}
