<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\FilterValue;

/**
 * Builder for model FilterValue
 *
 * @see FilterValue
 */
class FilterValueBuilder
{
    /**
     * @var FilterValue
     */
    private $instance;

    private function __construct(FilterValue $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new filter value Builder object.
     */
    public static function init(): self
    {
        return new self(new FilterValue());
    }

    /**
     * Sets all field.
     */
    public function all(?array $value): self
    {
        $this->instance->setAll($value);
        return $this;
    }

    /**
     * Unsets all field.
     */
    public function unsetAll(): self
    {
        $this->instance->unsetAll();
        return $this;
    }

    /**
     * Sets any field.
     */
    public function any(?array $value): self
    {
        $this->instance->setAny($value);
        return $this;
    }

    /**
     * Unsets any field.
     */
    public function unsetAny(): self
    {
        $this->instance->unsetAny();
        return $this;
    }

    /**
     * Sets none field.
     */
    public function none(?array $value): self
    {
        $this->instance->setNone($value);
        return $this;
    }

    /**
     * Unsets none field.
     */
    public function unsetNone(): self
    {
        $this->instance->unsetNone();
        return $this;
    }

    /**
     * Initializes a new filter value object.
     */
    public function build(): FilterValue
    {
        return CoreHelper::clone($this->instance);
    }
}
