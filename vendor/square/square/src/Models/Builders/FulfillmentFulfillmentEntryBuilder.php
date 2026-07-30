<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\FulfillmentFulfillmentEntry;

/**
 * Builder for model FulfillmentFulfillmentEntry
 *
 * @see FulfillmentFulfillmentEntry
 */
class FulfillmentFulfillmentEntryBuilder
{
    /**
     * @var FulfillmentFulfillmentEntry
     */
    private $instance;

    private function __construct(FulfillmentFulfillmentEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new fulfillment fulfillment entry Builder object.
     */
    public static function init(string $lineItemUid, string $quantity): self
    {
        return new self(new FulfillmentFulfillmentEntry($lineItemUid, $quantity));
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
     * Initializes a new fulfillment fulfillment entry object.
     */
    public function build(): FulfillmentFulfillmentEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
