<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerSegment;

/**
 * Builder for model CustomerSegment
 *
 * @see CustomerSegment
 */
class CustomerSegmentBuilder
{
    /**
     * @var CustomerSegment
     */
    private $instance;

    private function __construct(CustomerSegment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer segment Builder object.
     */
    public static function init(string $name): self
    {
        return new self(new CustomerSegment($name));
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
     * Initializes a new customer segment object.
     */
    public function build(): CustomerSegment
    {
        return CoreHelper::clone($this->instance);
    }
}
