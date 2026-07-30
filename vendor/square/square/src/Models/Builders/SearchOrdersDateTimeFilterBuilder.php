<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersDateTimeFilter;
use Square\Models\TimeRange;

/**
 * Builder for model SearchOrdersDateTimeFilter
 *
 * @see SearchOrdersDateTimeFilter
 */
class SearchOrdersDateTimeFilterBuilder
{
    /**
     * @var SearchOrdersDateTimeFilter
     */
    private $instance;

    private function __construct(SearchOrdersDateTimeFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders date time filter Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersDateTimeFilter());
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?TimeRange $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?TimeRange $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets closed at field.
     */
    public function closedAt(?TimeRange $value): self
    {
        $this->instance->setClosedAt($value);
        return $this;
    }

    /**
     * Initializes a new search orders date time filter object.
     */
    public function build(): SearchOrdersDateTimeFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
