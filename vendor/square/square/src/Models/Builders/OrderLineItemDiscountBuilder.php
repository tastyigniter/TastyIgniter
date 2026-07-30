<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderLineItemDiscount;

/**
 * Builder for model OrderLineItemDiscount
 *
 * @see OrderLineItemDiscount
 */
class OrderLineItemDiscountBuilder
{
    /**
     * @var OrderLineItemDiscount
     */
    private $instance;

    private function __construct(OrderLineItemDiscount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item discount Builder object.
     */
    public static function init(): self
    {
        return new self(new OrderLineItemDiscount());
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
     * Sets catalog object id field.
     */
    public function catalogObjectId(?string $value): self
    {
        $this->instance->setCatalogObjectId($value);
        return $this;
    }

    /**
     * Unsets catalog object id field.
     */
    public function unsetCatalogObjectId(): self
    {
        $this->instance->unsetCatalogObjectId();
        return $this;
    }

    /**
     * Sets catalog version field.
     */
    public function catalogVersion(?int $value): self
    {
        $this->instance->setCatalogVersion($value);
        return $this;
    }

    /**
     * Unsets catalog version field.
     */
    public function unsetCatalogVersion(): self
    {
        $this->instance->unsetCatalogVersion();
        return $this;
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
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
     * Sets percentage field.
     */
    public function percentage(?string $value): self
    {
        $this->instance->setPercentage($value);
        return $this;
    }

    /**
     * Unsets percentage field.
     */
    public function unsetPercentage(): self
    {
        $this->instance->unsetPercentage();
        return $this;
    }

    /**
     * Sets amount money field.
     */
    public function amountMoney(?Money $value): self
    {
        $this->instance->setAmountMoney($value);
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
     * Sets scope field.
     */
    public function scope(?string $value): self
    {
        $this->instance->setScope($value);
        return $this;
    }

    /**
     * Sets reward ids field.
     */
    public function rewardIds(?array $value): self
    {
        $this->instance->setRewardIds($value);
        return $this;
    }

    /**
     * Sets pricing rule id field.
     */
    public function pricingRuleId(?string $value): self
    {
        $this->instance->setPricingRuleId($value);
        return $this;
    }

    /**
     * Initializes a new order line item discount object.
     */
    public function build(): OrderLineItemDiscount
    {
        return CoreHelper::clone($this->instance);
    }
}
