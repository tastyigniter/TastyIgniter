<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalActionsRequest;
use Square\Models\TerminalActionQuery;

/**
 * Builder for model SearchTerminalActionsRequest
 *
 * @see SearchTerminalActionsRequest
 */
class SearchTerminalActionsRequestBuilder
{
    /**
     * @var SearchTerminalActionsRequest
     */
    private $instance;

    private function __construct(SearchTerminalActionsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal actions request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalActionsRequest());
    }

    /**
     * Sets query field.
     */
    public function query(?TerminalActionQuery $value): self
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
     * Initializes a new search terminal actions request object.
     */
    public function build(): SearchTerminalActionsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
