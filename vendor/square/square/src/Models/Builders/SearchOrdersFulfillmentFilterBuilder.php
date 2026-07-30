<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersFulfillmentFilter;

/**
 * Builder for model SearchOrdersFulfillmentFilter
 *
 * @see SearchOrdersFulfillmentFilter
 */
class SearchOrdersFulfillmentFilterBuilder
{
    /**
     * @var SearchOrdersFulfillmentFilter
     */
    private $instance;

    private function __construct(SearchOrdersFulfillmentFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders fulfillment filter Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersFulfillmentFilter());
    }

    /**
     * Sets fulfillment types field.
     */
    public function fulfillmentTypes(?array $value): self
    {
        $this->instance->setFulfillmentTypes($value);
        return $this;
    }

    /**
     * Unsets fulfillment types field.
     */
    public function unsetFulfillmentTypes(): self
    {
        $this->instance->unsetFulfillmentTypes();
        return $this;
    }

    /**
     * Sets fulfillment states field.
     */
    public function fulfillmentStates(?array $value): self
    {
        $this->instance->setFulfillmentStates($value);
        return $this;
    }

    /**
     * Unsets fulfillment states field.
     */
    public function unsetFulfillmentStates(): self
    {
        $this->instance->unsetFulfillmentStates();
        return $this;
    }

    /**
     * Initializes a new search orders fulfillment filter object.
     */
    public function build(): SearchOrdersFulfillmentFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
