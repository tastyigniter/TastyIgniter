<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersCustomerFilter;

/**
 * Builder for model SearchOrdersCustomerFilter
 *
 * @see SearchOrdersCustomerFilter
 */
class SearchOrdersCustomerFilterBuilder
{
    /**
     * @var SearchOrdersCustomerFilter
     */
    private $instance;

    private function __construct(SearchOrdersCustomerFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders customer filter Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersCustomerFilter());
    }

    /**
     * Sets customer ids field.
     */
    public function customerIds(?array $value): self
    {
        $this->instance->setCustomerIds($value);
        return $this;
    }

    /**
     * Unsets customer ids field.
     */
    public function unsetCustomerIds(): self
    {
        $this->instance->unsetCustomerIds();
        return $this;
    }

    /**
     * Initializes a new search orders customer filter object.
     */
    public function build(): SearchOrdersCustomerFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
