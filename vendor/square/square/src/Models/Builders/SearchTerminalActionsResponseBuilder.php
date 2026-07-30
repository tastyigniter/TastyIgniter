<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchTerminalActionsResponse;

/**
 * Builder for model SearchTerminalActionsResponse
 *
 * @see SearchTerminalActionsResponse
 */
class SearchTerminalActionsResponseBuilder
{
    /**
     * @var SearchTerminalActionsResponse
     */
    private $instance;

    private function __construct(SearchTerminalActionsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search terminal actions response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchTerminalActionsResponse());
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
     * Sets action field.
     */
    public function action(?array $value): self
    {
        $this->instance->setAction($value);
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
     * Initializes a new search terminal actions response object.
     */
    public function build(): SearchTerminalActionsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
