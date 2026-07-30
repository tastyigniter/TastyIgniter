<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerGroup;

/**
 * Builder for model CustomerGroup
 *
 * @see CustomerGroup
 */
class CustomerGroupBuilder
{
    /**
     * @var CustomerGroup
     */
    private $instance;

    private function __construct(CustomerGroup $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer group Builder object.
     */
    public static function init(string $name): self
    {
        return new self(new CustomerGroup($name));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new customer group object.
     */
    public function build(): CustomerGroup
    {
        return CoreHelper::clone($this->instance);
    }
}
