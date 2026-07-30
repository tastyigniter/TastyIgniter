<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWorkweekConfigsRequest;

/**
 * Builder for model ListWorkweekConfigsRequest
 *
 * @see ListWorkweekConfigsRequest
 */
class ListWorkweekConfigsRequestBuilder
{
    /**
     * @var ListWorkweekConfigsRequest
     */
    private $instance;

    private function __construct(ListWorkweekConfigsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list workweek configs request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWorkweekConfigsRequest());
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
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
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
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Initializes a new list workweek configs request object.
     */
    public function build(): ListWorkweekConfigsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
