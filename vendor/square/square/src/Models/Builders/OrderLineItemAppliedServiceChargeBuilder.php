<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderLineItemAppliedServiceCharge;

/**
 * Builder for model OrderLineItemAppliedServiceCharge
 *
 * @see OrderLineItemAppliedServiceCharge
 */
class OrderLineItemAppliedServiceChargeBuilder
{
    /**
     * @var OrderLineItemAppliedServiceCharge
     */
    private $instance;

    private function __construct(OrderLineItemAppliedServiceCharge $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item applied service charge Builder object.
     */
    public static function init(string $serviceChargeUid): self
    {
        return new self(new OrderLineItemAppliedServiceCharge($serviceChargeUid));
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
     * Sets applied money field.
     */
    public function appliedMoney(?Money $value): self
    {
        $this->instance->setAppliedMoney($value);
        return $this;
    }

    /**
     * Initializes a new order line item applied service charge object.
     */
    public function build(): OrderLineItemAppliedServiceCharge
    {
        return CoreHelper::clone($this->instance);
    }
}
