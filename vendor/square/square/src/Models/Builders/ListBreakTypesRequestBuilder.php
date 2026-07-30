<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBreakTypesRequest;

/**
 * Builder for model ListBreakTypesRequest
 *
 * @see ListBreakTypesRequest
 */
class ListBreakTypesRequestBuilder
{
    /**
     * @var ListBreakTypesRequest
     */
    private $instance;

    private function __construct(ListBreakTypesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list break types request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBreakTypesRequest());
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
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
     * Initializes a new list break types request object.
     */
    public function build(): ListBreakTypesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
