<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderLineItem;
use Square\Models\OrderLineItemPricingBlocklists;
use Square\Models\OrderQuantityUnit;

/**
 * Builder for model OrderLineItem
 *
 * @see OrderLineItem
 */
class OrderLineItemBuilder
{
    /**
     * @var OrderLineItem
     */
    private $instance;

    private function __construct(OrderLineItem $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order line item Builder object.
     */
    public static function init(string $quantity): self
    {
        return new self(new OrderLineItem($quantity));
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
     * Sets quantity unit field.
     */
    public function quantityUnit(?OrderQuantityUnit $value): self
    {
        $this->instance->setQuantityUnit($value);
        return $this;
    }

    /**
     * Sets note field.
     */
    public function note(?string $value): self
    {
        $this->instance->setNote($value);
        return $this;
    }

    /**
     * Unsets note field.
     */
    public function unsetNote(): self
    {
        $this->instance->unsetNote();
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
     * Sets variation name field.
     */
    public function variationName(?string $value): self
    {
        $this->instance->setVariationName($value);
        return $this;
    }

    /**
     * Unsets variation name field.
     */
    public function unsetVariationName(): self
    {
        $this->instance->unsetVariationName();
        return $this;
    }

    /**
     * Sets item type field.
     */
    public function itemType(?string $value): self
    {
        $this->instance->setItemType($value);
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
     * Sets modifiers field.
     */
    public function modifiers(?array $value): self
    {
        $this->instance->setModifiers($value);
        return $this;
    }

    /**
     * Unsets modifiers field.
     */
    public function unsetModifiers(): self
    {
        $this->instance->unsetModifiers();
        return $this;
    }

    /**
     * Sets applied taxes field.
     */
    public function appliedTaxes(?array $value): self
    {
        $this->instance->setAppliedTaxes($value);
        return $this;
    }

    /**
     * Unsets applied taxes field.
     */
    public function unsetAppliedTaxes(): self
    {
        $this->instance->unsetAppliedTaxes();
        return $this;
    }

    /**
     * Sets applied discounts field.
     */
    public function appliedDiscounts(?array $value): self
    {
        $this->instance->setAppliedDiscounts($value);
        return $this;
    }

    /**
     * Unsets applied discounts field.
     */
    public function unsetAppliedDiscounts(): self
    {
        $this->instance->unsetAppliedDiscounts();
        return $this;
    }

    /**
     * Sets applied service charges field.
     */
    public function appliedServiceCharges(?array $value): self
    {
        $this->instance->setAppliedServiceCharges($value);
        return $this;
    }

    /**
     * Unsets applied service charges field.
     */
    public function unsetAppliedServiceCharges(): self
    {
        $this->instance->unsetAppliedServiceCharges();
        return $this;
    }

    /**
     * Sets base price money field.
     */
    public function basePriceMoney(?Money $value): self
    {
        $this->instance->setBasePriceMoney($value);
        return $this;
    }

    /**
     * Sets variation total price money field.
     */
    public function variationTotalPriceMoney(?Money $value): self
    {
        $this->instance->setVariationTotalPriceMoney($value);
        return $this;
    }

    /**
     * Sets gross sales money field.
     */
    public function grossSalesMoney(?Money $value): self
    {
        $this->instance->setGrossSalesMoney($value);
        return $this;
    }

    /**
     * Sets total tax money field.
     */
    public function totalTaxMoney(?Money $value): self
    {
        $this->instance->setTotalTaxMoney($value);
        return $this;
    }

    /**
     * Sets total discount money field.
     */
    public function totalDiscountMoney(?Money $value): self
    {
        $this->instance->setTotalDiscountMoney($value);
        return $this;
    }

    /**
     * Sets total money field.
     */
    public function totalMoney(?Money $value): self
    {
        $this->instance->setTotalMoney($value);
        return $this;
    }

    /**
     * Sets pricing blocklists field.
     */
    public function pricingBlocklists(?OrderLineItemPricingBlocklists $value): self
    {
        $this->instance->setPricingBlocklists($value);
        return $this;
    }

    /**
     * Sets total service charge money field.
     */
    public function totalServiceChargeMoney(?Money $value): self
    {
        $this->instance->setTotalServiceChargeMoney($value);
        return $this;
    }

    /**
     * Initializes a new order line item object.
     */
    public function build(): OrderLineItem
    {
        return CoreHelper::clone($this->instance);
    }
}
