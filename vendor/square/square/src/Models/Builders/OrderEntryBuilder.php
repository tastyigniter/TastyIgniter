<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderEntry;

/**
 * Builder for model OrderEntry
 *
 * @see OrderEntry
 */
class OrderEntryBuilder
{
    /**
     * @var OrderEntry
     */
    private $instance;

    private function __construct(OrderEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order entry Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderEntry());
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
     * Initializes a new order entry object.
     */
    public function build(): OrderEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
