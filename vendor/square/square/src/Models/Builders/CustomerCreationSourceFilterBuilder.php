<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerCreationSourceFilter;

/**
 * Builder for model CustomerCreationSourceFilter
 *
 * @see CustomerCreationSourceFilter
 */
class CustomerCreationSourceFilterBuilder
{
    /**
     * @var CustomerCreationSourceFilter
     */
    private $instance;

    private function __construct(CustomerCreationSourceFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer creation source filter Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerCreationSourceFilter());
    }

    /**
     * Sets values field.
     */
    public function values(?array $value): self
    {
        $this->instance->setValues($value);
        return $this;
    }

    /**
     * Unsets values field.
     */
    public function unsetValues(): self
    {
        $this->instance->unsetValues();
        return $this;
    }

    /**
     * Sets rule field.
     */
    public function rule(?string $value): self
    {
        $this->instance->setRule($value);
        return $this;
    }

    /**
     * Initializes a new customer creation source filter object.
     */
    public function build(): CustomerCreationSourceFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
