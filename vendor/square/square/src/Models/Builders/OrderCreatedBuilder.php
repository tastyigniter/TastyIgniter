<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderCreated;

/**
 * Builder for model OrderCreated
 *
 * @see OrderCreated
 */
class OrderCreatedBuilder
{
    /**
     * @var OrderCreated
     */
    private $instance;

    private function __construct(OrderCreated $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order created Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderCreated());
    }

    /**
     * Sets order id field.
     */
    public function orderId(?string $value): self
    {
        $this->instance->setOrderId($value);
        return $this;
    }

    /**
     * Unsets order id field.
     */
    public function unsetOrderId(): self
    {
        $this->instance->unsetOrderId();
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets state field.
     */
    public function state(?string $value): self
    {
        $this->instance->setState($value);
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
     * Initializes a new order created object.
     */
    public function build(): OrderCreated
    {
        return CoreHelper::clone($this->instance);
    }
}
