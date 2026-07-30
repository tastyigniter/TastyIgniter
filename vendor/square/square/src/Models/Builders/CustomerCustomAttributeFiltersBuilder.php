<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerCustomAttributeFilters;

/**
 * Builder for model CustomerCustomAttributeFilters
 *
 * @see CustomerCustomAttributeFilters
 */
class CustomerCustomAttributeFiltersBuilder
{
    /**
     * @var CustomerCustomAttributeFilters
     */
    private $instance;

    private function __construct(CustomerCustomAttributeFilters $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer custom attribute filters Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerCustomAttributeFilters());
    }

    /**
     * Sets filters field.
     */
    public function filters(?array $value): self
    {
        $this->instance->setFilters($value);
        return $this;
    }

    /**
     * Unsets filters field.
     */
    public function unsetFilters(): self
    {
        $this->instance->unsetFilters();
        return $this;
    }

    /**
     * Initializes a new customer custom attribute filters object.
     */
    public function build(): CustomerCustomAttributeFilters
    {
        return CoreHelper::clone($this->instance);
    }
}
