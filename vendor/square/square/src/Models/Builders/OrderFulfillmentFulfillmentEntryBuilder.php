<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderFulfillmentFulfillmentEntry;

/**
 * Builder for model OrderFulfillmentFulfillmentEntry
 *
 * @see OrderFulfillmentFulfillmentEntry
 */
class OrderFulfillmentFulfillmentEntryBuilder
{
    /**
     * @var OrderFulfillmentFulfillmentEntry
     */
    private $instance;

    private function __construct(OrderFulfillmentFulfillmentEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order fulfillment fulfillment entry Builder object.
     */
    public static function init(string $lineItemUid, string $quantity): self
    {
        return new self(new OrderFulfillmentFulfillmentEntry($lineItemUid, $quantity));
    }

    /**
     * Sets uid field.
     */
    public function uid(?string $value): self
    {
        $this->instance->setUid($value);
        return $this;
    }

    /**
     * Unsets uid field.
     */
    public function unsetUid(): self
    {
        $this->instance->unsetUid();
        return $this;
    }

    /**
     * Sets metadata field.
     */
    public function metadata(?array $value): self
    {
        $this->instance->setMetadata($value);
        return $this;
    }

    /**
     * Unsets metadata field.
     */
    public function unsetMetadata(): self
    {
        $this->instance->unsetMetadata();
        return $this;
    }

    /**
     * Initializes a new order fulfillment fulfillment entry object.
     */
    public function build(): OrderFulfillmentFulfillmentEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
