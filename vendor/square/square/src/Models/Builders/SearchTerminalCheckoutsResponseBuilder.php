<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalCheckoutsResponse;

/**
 * Builder for model SearchTerminalCheckoutsResponse
 *
 * @see SearchTerminalCheckoutsResponse
 */
class SearchTerminalCheckoutsResponseBuilder
{
    /**
     * @var SearchTerminalCheckoutsResponse
     */
    private $instance;

    private function __construct(SearchTerminalCheckoutsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal checkouts response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalCheckoutsResponse());
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
     * Sets checkouts field.
     */
    public function checkouts(?array $value): self
    {
        $this->instance->setCheckouts($value);
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
     * Initializes a new search terminal checkouts response object.
     */
    public function build(): SearchTerminalCheckoutsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
