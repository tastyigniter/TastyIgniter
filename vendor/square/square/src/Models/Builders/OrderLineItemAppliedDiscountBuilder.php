<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderLineItemAppliedDiscount;

/**
 * Builder for model OrderLineItemAppliedDiscount
 *
 * @see OrderLineItemAppliedDiscount
 */
class OrderLineItemAppliedDiscountBuilder
{
    /**
     * @var OrderLineItemAppliedDiscount
     */
    private $instance;

    private function __construct(OrderLineItemAppliedDiscount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item applied discount Builder object.
     */
    public static function init(string $discountUid): self
    {
        return new self(new OrderLineItemAppliedDiscount($discountUid));
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
     * Initializes a new order line item applied discount object.
     */
    public function build(): OrderLineItemAppliedDiscount
    {
        return CoreHelper::clone($this->instance);
    }
}
