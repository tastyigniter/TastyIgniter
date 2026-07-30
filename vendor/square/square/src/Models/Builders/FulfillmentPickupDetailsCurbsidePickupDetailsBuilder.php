<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\FulfillmentPickupDetailsCurbsidePickupDetails;

/**
 * Builder for model FulfillmentPickupDetailsCurbsidePickupDetails
 *
 * @see FulfillmentPickupDetailsCurbsidePickupDetails
 */
class FulfillmentPickupDetailsCurbsidePickupDetailsBuilder
{
    /**
     * @var FulfillmentPickupDetailsCurbsidePickupDetails
     */
    private $instance;

    private function __construct(FulfillmentPickupDetailsCurbsidePickupDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new fulfillment pickup details curbside pickup details Builder object.
     */
    public static function init(): self
    {
        return new self(new FulfillmentPickupDetailsCurbsidePickupDetails());
    }

    /**
     * Sets curbside details field.
     */
    public function curbsideDetails(?string $value): self
    {
        $this->instance->setCurbsideDetails($value);
        return $this;
    }

    /**
     * Unsets curbside details field.
     */
    public function unsetCurbsideDetails(): self
    {
        $this->instance->unsetCurbsideDetails();
        return $this;
    }

    /**
     * Sets buyer arrived at field.
     */
    public function buyerArrivedAt(?string $value): self
    {
        $this->instance->setBuyerArrivedAt($value);
        return $this;
    }

    /**
     * Unsets buyer arrived at field.
     */
    public function unsetBuyerArrivedAt(): self
    {
        $this->instance->unsetBuyerArrivedAt();
        return $this;
    }

    /**
     * Initializes a new fulfillment pickup details curbside pickup details object.
     */
    public function build(): FulfillmentPickupDetailsCurbsidePickupDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
