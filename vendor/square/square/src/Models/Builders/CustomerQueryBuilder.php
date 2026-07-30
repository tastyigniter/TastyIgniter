<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerFilter;
use Square\Models\CustomerQuery;
use Square\Models\CustomerSort;

/**
 * Builder for model CustomerQuery
 *
 * @see CustomerQuery
 */
class CustomerQueryBuilder
{
    /**
     * @var CustomerQuery
     */
    private $instance;

    private function __construct(CustomerQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer query Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?CustomerFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?CustomerSort $value): self
    {
        $this->instance->setSort($value);
        return $this;
    }

    /**
     * Initializes a new customer query object.
     */
    public function build(): CustomerQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
