<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchVendorsRequest;
use Square\Models\SearchVendorsRequestFilter;
use Square\Models\SearchVendorsRequestSort;

/**
 * Builder for model SearchVendorsRequest
 *
 * @see SearchVendorsRequest
 */
class SearchVendorsRequestBuilder
{
    /**
     * @var SearchVendorsRequest
     */
    private $instance;

    private function __construct(SearchVendorsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search vendors request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchVendorsRequest());
    }

    /**
     * Sets filter field.
     */
    public function filter(?SearchVendorsRequestFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?SearchVendorsRequestSort $value): self
    {
        $this->instance->setSort($value);
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
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Initializes a new search vendors request object.
     */
    public function build(): SearchVendorsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
