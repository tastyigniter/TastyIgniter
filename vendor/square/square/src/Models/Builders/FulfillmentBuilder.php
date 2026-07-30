<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Fulfillment;
use Square\Models\FulfillmentDeliveryDetails;
use Square\Models\FulfillmentPickupDetails;
use Square\Models\FulfillmentShipmentDetails;

/**
 * Builder for model Fulfillment
 *
 * @see Fulfillment
 */
class FulfillmentBuilder
{
    /**
     * @var Fulfillment
     */
    private $instance;

    private function __construct(Fulfillment $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new fulfillment Builder object.
     */
    public static function init(): self
    {
        return new self(new Fulfillment());
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
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
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
     * Sets line item application field.
     */
    public function lineItemApplication(?string $value): self
    {
        $this->instance->setLineItemApplication($value);
        return $this;
    }

    /**
     * Sets entries field.
     */
    public function entries(?array $value): self
    {
        $this->instance->setEntries($value);
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
     * Sets pickup details field.
     */
    public function pickupDetails(?FulfillmentPickupDetails $value): self
    {
        $this->instance->setPickupDetails($value);
        return $this;
    }

    /**
     * Sets shipment details field.
     */
    public function shipmentDetails(?FulfillmentShipmentDetails $value): self
    {
        $this->instance->setShipmentDetails($value);
        return $this;
    }

    /**
     * Sets delivery details field.
     */
    public function deliveryDetails(?FulfillmentDeliveryDetails $value): self
    {
        $this->instance->setDeliveryDetails($value);
        return $this;
    }

    /**
     * Initializes a new fulfillment object.
     */
    public function build(): Fulfillment
    {
        return CoreHelper::clone($this->instance);
    }
}
