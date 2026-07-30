<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderFulfillmentUpdatedUpdate;

/**
 * Builder for model OrderFulfillmentUpdatedUpdate
 *
 * @see OrderFulfillmentUpdatedUpdate
 */
class OrderFulfillmentUpdatedUpdateBuilder
{
    /**
     * @var OrderFulfillmentUpdatedUpdate
     */
    private $instance;

    private function __construct(OrderFulfillmentUpdatedUpdate $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order fulfillment updated update Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderFulfillmentUpdatedUpdate());
    }

    /**
     * Sets fulfillment uid field.
     */
    public function fulfillmentUid(?string $value): self
    {
        $this->instance->setFulfillmentUid($value);
        return $this;
    }

    /**
     * Unsets fulfillment uid field.
     */
    public function unsetFulfillmentUid(): self
    {
        $this->instance->unsetFulfillmentUid();
        return $this;
    }

    /**
     * Sets old state field.
     */
    public function oldState(?string $value): self
    {
        $this->instance->setOldState($value);
        return $this;
    }

    /**
     * Sets new state field.
     */
    public function newState(?string $value): self
    {
        $this->instance->setNewState($value);
        return $this;
    }

    /**
     * Initializes a new order fulfillment updated update object.
     */
    public function build(): OrderFulfillmentUpdatedUpdate
    {
        return CoreHelper::clone($this->instance);
    }
}
