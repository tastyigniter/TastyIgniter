<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchOrdersQuery;
use Square\Models\SearchOrdersRequest;

/**
 * Builder for model SearchOrdersRequest
 *
 * @see SearchOrdersRequest
 */
class SearchOrdersRequestBuilder
{
    /**
     * @var SearchOrdersRequest
     */
    private $instance;

    private function __construct(SearchOrdersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search orders request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchOrdersRequest());
    }

    /**
     * Sets location ids field.
     */
    public function locationIds(?array $value): self
    {
        $this->instance->setLocationIds($value);
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
     * Sets query field.
     */
    public function query(?SearchOrdersQuery $value): self
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
     * Sets return entries field.
     */
    public function returnEntries(?bool $value): self
    {
        $this->instance->setReturnEntries($value);
        return $this;
    }

    /**
     * Initializes a new search orders request object.
     */
    public function build(): SearchOrdersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
