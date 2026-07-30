<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersSourceFilter;

/**
 * Builder for model SearchOrdersSourceFilter
 *
 * @see SearchOrdersSourceFilter
 */
class SearchOrdersSourceFilterBuilder
{
    /**
     * @var SearchOrdersSourceFilter
     */
    private $instance;

    private function __construct(SearchOrdersSourceFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders source filter Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersSourceFilter());
    }

    /**
     * Sets source names field.
     */
    public function sourceNames(?array $value): self
    {
        $this->instance->setSourceNames($value);
        return $this;
    }

    /**
     * Unsets source names field.
     */
    public function unsetSourceNames(): self
    {
        $this->instance->unsetSourceNames();
        return $this;
    }

    /**
     * Initializes a new search orders source filter object.
     */
    public function build(): SearchOrdersSourceFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
