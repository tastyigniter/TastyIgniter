<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchLoyaltyEventsResponse;

/**
 * Builder for model SearchLoyaltyEventsResponse
 *
 * @see SearchLoyaltyEventsResponse
 */
class SearchLoyaltyEventsResponseBuilder
{
    /**
     * @var SearchLoyaltyEventsResponse
     */
    private $instance;

    private function __construct(SearchLoyaltyEventsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search loyalty events response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchLoyaltyEventsResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets events field.
     */
    public function events(?array $value): self
    {
        $this->instance->setEvents($value);
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
     * Initializes a new search loyalty events response object.
     */
    public function build(): SearchLoyaltyEventsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
