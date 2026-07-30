<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\OrderLineItemPricingBlocklistsBlockedDiscount;

/**
 * Builder for model OrderLineItemPricingBlocklistsBlockedDiscount
 *
 * @see OrderLineItemPricingBlocklistsBlockedDiscount
 */
class OrderLineItemPricingBlocklistsBlockedDiscountBuilder
{
    /**
     * @var OrderLineItemPricingBlocklistsBlockedDiscount
     */
    private $instance;

    private function __construct(OrderLineItemPricingBlocklistsBlockedDiscount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item pricing blocklists blocked discount Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderLineItemPricingBlocklistsBlockedDiscount());
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
     * Sets discount uid field.
     */
    public function discountUid(?string $value): self
    {
        $this->instance->setDiscountUid($value);
        return $this;
    }

    /**
     * Unsets discount uid field.
     */
    public function unsetDiscountUid(): self
    {
        $this->instance->unsetDiscountUid();
        return $this;
    }

    /**
     * Sets discount catalog object id field.
     */
    public function discountCatalogObjectId(?string $value): self
    {
        $this->instance->setDiscountCatalogObjectId($value);
        return $this;
    }

    /**
     * Unsets discount catalog object id field.
     */
    public function unsetDiscountCatalogObjectId(): self
    {
        $this->instance->unsetDiscountCatalogObjectId();
        return $this;
    }

    /**
     * Initializes a new order line item pricing blocklists blocked discount object.
     */
    public function build(): OrderLineItemPricingBlocklistsBlockedDiscount
    {
        return CoreHelper::clone($this->instance);
    }
}
