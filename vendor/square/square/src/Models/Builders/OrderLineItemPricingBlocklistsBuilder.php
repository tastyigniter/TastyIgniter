<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderLineItemPricingBlocklists;

/**
 * Builder for model OrderLineItemPricingBlocklists
 *
 * @see OrderLineItemPricingBlocklists
 */
class OrderLineItemPricingBlocklistsBuilder
{
    /**
     * @var OrderLineItemPricingBlocklists
     */
    private $instance;

    private function __construct(OrderLineItemPricingBlocklists $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item pricing blocklists Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderLineItemPricingBlocklists());
    }

    /**
     * Sets blocked discounts field.
     */
    public function blockedDiscounts(?array $value): self
    {
        $this->instance->setBlockedDiscounts($value);
        return $this;
    }

    /**
     * Unsets blocked discounts field.
     */
    public function unsetBlockedDiscounts(): self
    {
        $this->instance->unsetBlockedDiscounts();
        return $this;
    }

    /**
     * Sets blocked taxes field.
     */
    public function blockedTaxes(?array $value): self
    {
        $this->instance->setBlockedTaxes($value);
        return $this;
    }

    /**
     * Unsets blocked taxes field.
     */
    public function unsetBlockedTaxes(): self
    {
        $this->instance->unsetBlockedTaxes();
        return $this;
    }

    /**
     * Initializes a new order line item pricing blocklists object.
     */
    public function build(): OrderLineItemPricingBlocklists
    {
        return CoreHelper::clone($this->instance);
    }
}
