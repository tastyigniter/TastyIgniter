<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderLineItemAppliedTax;

/**
 * Builder for model OrderLineItemAppliedTax
 *
 * @see OrderLineItemAppliedTax
 */
class OrderLineItemAppliedTaxBuilder
{
    /**
     * @var OrderLineItemAppliedTax
     */
    private $instance;

    private function __construct(OrderLineItemAppliedTax $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item applied tax Builder object.
     */
    public static function init(string $taxUid): self
    {
        return new self(new OrderLineItemAppliedTax($taxUid));
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
     * Initializes a new order line item applied tax object.
     */
    public function build(): OrderLineItemAppliedTax
    {
        return CoreHelper::clone($this->instance);
    }
}
