<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerQuery;
use Square\Models\SearchCustomersRequest;

/**
 * Builder for model SearchCustomersRequest
 *
 * @see SearchCustomersRequest
 */
class SearchCustomersRequestBuilder
{
    /**
     * @var SearchCustomersRequest
     */
    private $instance;

    private function __construct(SearchCustomersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search customers request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCustomersRequest());
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
     * Sets query field.
     */
    public function query(?CustomerQuery $value): self
    {
        $this->instance->setQuery($value);
        return $this;
    }

    /**
     * Initializes a new search customers request object.
     */
    public function build(): SearchCustomersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
