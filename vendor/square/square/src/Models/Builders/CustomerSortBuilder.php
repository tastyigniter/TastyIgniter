<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerSort;

/**
 * Builder for model CustomerSort
 *
 * @see CustomerSort
 */
class CustomerSortBuilder
{
    /**
     * @var CustomerSort
     */
    private $instance;

    private function __construct(CustomerSort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer sort Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerSort());
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
     * Initializes a new customer sort object.
     */
    public function build(): CustomerSort
    {
        return CoreHelper::clone($this->instance);
    }
}
