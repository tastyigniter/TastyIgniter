<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalCheckoutsRequest;
use Square\Models\TerminalCheckoutQuery;

/**
 * Builder for model SearchTerminalCheckoutsRequest
 *
 * @see SearchTerminalCheckoutsRequest
 */
class SearchTerminalCheckoutsRequestBuilder
{
    /**
     * @var SearchTerminalCheckoutsRequest
     */
    private $instance;

    private function __construct(SearchTerminalCheckoutsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal checkouts request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalCheckoutsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?TerminalCheckoutQuery $value): self
    {
        $this->instance->setQuery($value);
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
     * Initializes a new search terminal checkouts request object.
     */
    public function build(): SearchTerminalCheckoutsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
