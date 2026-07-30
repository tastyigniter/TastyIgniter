<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderUpdated;
use Square\Models\OrderUpdatedObject;

/**
 * Builder for model OrderUpdatedObject
 *
 * @see OrderUpdatedObject
 */
class OrderUpdatedObjectBuilder
{
    /**
     * @var OrderUpdatedObject
     */
    private $instance;

    private function __construct(OrderUpdatedObject $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order updated object Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderUpdatedObject());
    }

    /**
     * Sets order updated field.
     */
    public function orderUpdated(?OrderUpdated $value): self
    {
        $this->instance->setOrderUpdated($value);
        return $this;
    }

    /**
     * Initializes a new order updated object object.
     */
    public function build(): OrderUpdatedObject
    {
        return CoreHelper::clone($this->instance);
    }
}
