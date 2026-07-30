<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchVendorsRequestSort;

/**
 * Builder for model SearchVendorsRequestSort
 *
 * @see SearchVendorsRequestSort
 */
class SearchVendorsRequestSortBuilder
{
    /**
     * @var SearchVendorsRequestSort
     */
    private $instance;

    private function __construct(SearchVendorsRequestSort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search vendors request sort Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchVendorsRequestSort());
    }

    /**
     * Sets field field.
     */
    public function field(?string $value): self
    {
        $this->instance->setField($value);
        return $this;
    }

    /**
     * Sets order field.
     */
    public function order(?string $value): self
    {
        $this->instance->setOrder($value);
        return $this;
    }

    /**
     * Initializes a new search vendors request sort object.
     */
    public function build(): SearchVendorsRequestSort
    {
        return CoreHelper::clone($this->instance);
    }
}
