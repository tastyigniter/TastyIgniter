<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderFulfillmentUpdated;

/**
 * Builder for model OrderFulfillmentUpdated
 *
 * @see OrderFulfillmentUpdated
 */
class OrderFulfillmentUpdatedBuilder
{
    /**
     * @var OrderFulfillmentUpdated
     */
    private $instance;

    private function __construct(OrderFulfillmentUpdated $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order fulfillment updated Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderFulfillmentUpdated());
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
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets fulfillment update field.
     */
    public function fulfillmentUpdate(?array $value): self
    {
        $this->instance->setFulfillmentUpdate($value);
        return $this;
    }

    /**
     * Unsets fulfillment update field.
     */
    public function unsetFulfillmentUpdate(): self
    {
        $this->instance->unsetFulfillmentUpdate();
        return $this;
    }

    /**
     * Initializes a new order fulfillment updated object.
     */
    public function build(): OrderFulfillmentUpdated
    {
        return CoreHelper::clone($this->instance);
    }
}
