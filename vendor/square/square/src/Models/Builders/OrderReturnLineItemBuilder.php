<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\OrderQuantityUnit;
use Square\Models\OrderReturnLineItem;

/**
 * Builder for model OrderReturnLineItem
 *
 * @see OrderReturnLineItem
 */
class OrderReturnLineItemBuilder
{
    /**
     * @var OrderReturnLineItem
     */
    private $instance;

    private function __construct(OrderReturnLineItem $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new order return line item Builder object.
     */
    public static function init(string $quantity): self
    {
        return new self(new OrderReturnLineItem($quantity));
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
     * Sets source line item uid field.
     */
    public function sourceLineItemUid(?string $value): self
    {
        $this->instance->setSourceLineItemUid($value);
        return $this;
    }

    /**
     * Unsets source line item uid field.
     */
    public function unsetSourceLineItemUid(): self
    {
        $this->instance->unsetSourceLineItemUid();
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
     * Sets return modifiers field.
     */
    public function returnModifiers(?array $value): self
    {
        $this->instance->setReturnModifiers($value);
        return $this;
    }

    /**
     * Unsets return modifiers field.
     */
    public function unsetReturnModifiers(): self
    {
        $this->instance->unsetReturnModifiers();
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
     * Sets gross return money field.
     */
    public function grossReturnMoney(?Money $value): self
    {
        $this->instance->setGrossReturnMoney($value);
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
     * Sets total service charge money field.
     */
    public function totalServiceChargeMoney(?Money $value): self
    {
        $this->instance->setTotalServiceChargeMoney($value);
        return $this;
    }

    /**
     * Initializes a new order return line item object.
     */
    public function build(): OrderReturnLineItem
    {
        return CoreHelper::clone($this->instance);
    }
}
