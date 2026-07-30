<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ShiftSort;

/**
 * Builder for model ShiftSort
 *
 * @see ShiftSort
 */
class ShiftSortBuilder
{
    /**
     * @var ShiftSort
     */
    private $instance;

    private function __construct(ShiftSort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new shift sort Builder object.
     */
    public static function init(): self
    {
        return new self(new ShiftSort());
    }

    /**
     * Sets field field.
     */
    public function field(?string $value): self
    {
        $this->instance->setField($value);
        return $this;
    }

    /**
     * Sets order field.
     */
    public function order(?string $value): self
    {
        $this->instance->setOrder($value);
        return $this;
    }

    /**
     * Initializes a new shift sort object.
     */
    public function build(): ShiftSort
    {
        return CoreHelper::clone($this->instance);
    }
}
