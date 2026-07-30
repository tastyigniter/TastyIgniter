<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerCustomAttributeFilter;
use Square\Models\CustomerCustomAttributeFilterValue;
use Square\Models\TimeRange;

/**
 * Builder for model CustomerCustomAttributeFilter
 *
 * @see CustomerCustomAttributeFilter
 */
class CustomerCustomAttributeFilterBuilder
{
    /**
     * @var CustomerCustomAttributeFilter
     */
    private $instance;

    private function __construct(CustomerCustomAttributeFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer custom attribute filter Builder object.
     */
    public static function init(string $key): self
    {
        return new self(new CustomerCustomAttributeFilter($key));
    }

    /**
     * Sets filter field.
     */
    public function filter(?CustomerCustomAttributeFilterValue $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?TimeRange $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new customer custom attribute filter object.
     */
    public function build(): CustomerCustomAttributeFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
