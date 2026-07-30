<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListBreakTypesResponse;

/**
 * Builder for model ListBreakTypesResponse
 *
 * @see ListBreakTypesResponse
 */
class ListBreakTypesResponseBuilder
{
    /**
     * @var ListBreakTypesResponse
     */
    private $instance;

    private function __construct(ListBreakTypesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list break types response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListBreakTypesResponse());
    }

    /**
     * Sets break types field.
     */
    public function breakTypes(?array $value): self
    {
        $this->instance->setBreakTypes($value);
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
     * Initializes a new list break types response object.
     */
    public function build(): ListBreakTypesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
