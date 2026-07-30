<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Range;

/**
 * Builder for model Range
 *
 * @see Range
 */
class RangeBuilder
{
    /**
     * @var Range
     */
    private $instance;

    private function __construct(Range $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new range Builder object.
     */
    public static function init(): self
    {
        return new self(new Range());
    }

    /**
     * Sets min field.
     */
    public function min(?string $value): self
    {
        $this->instance->setMin($value);
        return $this;
    }

    /**
     * Unsets min field.
     */
    public function unsetMin(): self
    {
        $this->instance->unsetMin();
        return $this;
    }

    /**
     * Sets max field.
     */
    public function max(?string $value): self
    {
        $this->instance->setMax($value);
        return $this;
    }

    /**
     * Unsets max field.
     */
    public function unsetMax(): self
    {
        $this->instance->unsetMax();
        return $this;
    }

    /**
     * Initializes a new range object.
     */
    public function build(): Range
    {
        return CoreHelper::clone($this->instance);
    }
}
