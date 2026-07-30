<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalRefundsRequest;
use Square\Models\TerminalRefundQuery;

/**
 * Builder for model SearchTerminalRefundsRequest
 *
 * @see SearchTerminalRefundsRequest
 */
class SearchTerminalRefundsRequestBuilder
{
    /**
     * @var SearchTerminalRefundsRequest
     */
    private $instance;

    private function __construct(SearchTerminalRefundsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal refunds request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalRefundsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?TerminalRefundQuery $value): self
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
     * Initializes a new search terminal refunds request object.
     */
    public function build(): SearchTerminalRefundsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
