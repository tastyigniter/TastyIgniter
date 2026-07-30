<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalRefundsResponse;

/**
 * Builder for model SearchTerminalRefundsResponse
 *
 * @see SearchTerminalRefundsResponse
 */
class SearchTerminalRefundsResponseBuilder
{
    /**
     * @var SearchTerminalRefundsResponse
     */
    private $instance;

    private function __construct(SearchTerminalRefundsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal refunds response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalRefundsResponse());
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
     * Sets refunds field.
     */
    public function refunds(?array $value): self
    {
        $this->instance->setRefunds($value);
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
     * Initializes a new search terminal refunds response object.
     */
    public function build(): SearchTerminalRefundsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
