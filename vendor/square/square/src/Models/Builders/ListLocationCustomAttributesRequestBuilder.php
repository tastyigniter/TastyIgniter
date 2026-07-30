<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListLocationCustomAttributesRequest;

/**
 * Builder for model ListLocationCustomAttributesRequest
 *
 * @see ListLocationCustomAttributesRequest
 */
class ListLocationCustomAttributesRequestBuilder
{
    /**
     * @var ListLocationCustomAttributesRequest
     */
    private $instance;

    private function __construct(ListLocationCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list location custom attributes request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListLocationCustomAttributesRequest());
    }

    /**
     * Sets visibility filter field.
     */
    public function visibilityFilter(?string $value): self
    {
        $this->instance->setVisibilityFilter($value);
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
     * Sets with definitions field.
     */
    public function withDefinitions(?bool $value): self
    {
        $this->instance->setWithDefinitions($value);
        return $this;
    }

    /**
     * Unsets with definitions field.
     */
    public function unsetWithDefinitions(): self
    {
        $this->instance->unsetWithDefinitions();
        return $this;
    }

    /**
     * Initializes a new list location custom attributes request object.
     */
    public function build(): ListLocationCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
