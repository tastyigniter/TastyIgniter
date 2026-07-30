<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListWorkweekConfigsResponse;

/**
 * Builder for model ListWorkweekConfigsResponse
 *
 * @see ListWorkweekConfigsResponse
 */
class ListWorkweekConfigsResponseBuilder
{
    /**
     * @var ListWorkweekConfigsResponse
     */
    private $instance;

    private function __construct(ListWorkweekConfigsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list workweek configs response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListWorkweekConfigsResponse());
    }

    /**
     * Sets workweek configs field.
     */
    public function workweekConfigs(?array $value): self
    {
        $this->instance->setWorkweekConfigs($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new list workweek configs response object.
     */
    public function build(): ListWorkweekConfigsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
