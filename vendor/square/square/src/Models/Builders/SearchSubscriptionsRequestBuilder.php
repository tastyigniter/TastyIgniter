<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchSubscriptionsQuery;
use Square\Models\SearchSubscriptionsRequest;

/**
 * Builder for model SearchSubscriptionsRequest
 *
 * @see SearchSubscriptionsRequest
 */
class SearchSubscriptionsRequestBuilder
{
    /**
     * @var SearchSubscriptionsRequest
     */
    private $instance;

    private function __construct(SearchSubscriptionsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search subscriptions request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchSubscriptionsRequest());
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
    public function query(?SearchSubscriptionsQuery $value): self
    {
        $this->instance->setQuery($value);
        return $this;
    }

    /**
     * Sets include field.
     */
    public function include(?array $value): self
    {
        $this->instance->setInclude($value);
        return $this;
    }

    /**
     * Initializes a new search subscriptions request object.
     */
    public function build(): SearchSubscriptionsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
