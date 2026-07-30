<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderCreated;
use Square\Models\OrderCreatedObject;

/**
 * Builder for model OrderCreatedObject
 *
 * @see OrderCreatedObject
 */
class OrderCreatedObjectBuilder
{
    /**
     * @var OrderCreatedObject
     */
    private $instance;

    private function __construct(OrderCreatedObject $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order created object Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderCreatedObject());
    }

    /**
     * Sets order created field.
     */
    public function orderCreated(?OrderCreated $value): self
    {
        $this->instance->setOrderCreated($value);
        return $this;
    }

    /**
     * Initializes a new order created object object.
     */
    public function build(): OrderCreatedObject
    {
        return CoreHelper::clone($this->instance);
    }
}
