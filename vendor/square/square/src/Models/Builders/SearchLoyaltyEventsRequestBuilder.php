<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventQuery;
use Square\Models\SearchLoyaltyEventsRequest;

/**
 * Builder for model SearchLoyaltyEventsRequest
 *
 * @see SearchLoyaltyEventsRequest
 */
class SearchLoyaltyEventsRequestBuilder
{
    /**
     * @var SearchLoyaltyEventsRequest
     */
    private $instance;

    private function __construct(SearchLoyaltyEventsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty events request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyEventsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?LoyaltyEventQuery $value): self
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
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new search loyalty events request object.
     */
    public function build(): SearchLoyaltyEventsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
