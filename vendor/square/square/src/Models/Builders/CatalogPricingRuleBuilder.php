<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogPricingRule;
use Square\Models\Money;

/**
 * Builder for model CatalogPricingRule
 *
 * @see CatalogPricingRule
 */
class CatalogPricingRuleBuilder
{
    /**
     * @var CatalogPricingRule
     */
    private $instance;

    private function __construct(CatalogPricingRule $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog pricing rule Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogPricingRule());
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
     * Sets time period ids field.
     */
    public function timePeriodIds(?array $value): self
    {
        $this->instance->setTimePeriodIds($value);
        return $this;
    }

    /**
     * Unsets time period ids field.
     */
    public function unsetTimePeriodIds(): self
    {
        $this->instance->unsetTimePeriodIds();
        return $this;
    }

    /**
     * Sets discount id field.
     */
    public function discountId(?string $value): self
    {
        $this->instance->setDiscountId($value);
        return $this;
    }

    /**
     * Unsets discount id field.
     */
    public function unsetDiscountId(): self
    {
        $this->instance->unsetDiscountId();
        return $this;
    }

    /**
     * Sets match products id field.
     */
    public function matchProductsId(?string $value): self
    {
        $this->instance->setMatchProductsId($value);
        return $this;
    }

    /**
     * Unsets match products id field.
     */
    public function unsetMatchProductsId(): self
    {
        $this->instance->unsetMatchProductsId();
        return $this;
    }

    /**
     * Sets apply products id field.
     */
    public function applyProductsId(?string $value): self
    {
        $this->instance->setApplyProductsId($value);
        return $this;
    }

    /**
     * Unsets apply products id field.
     */
    public function unsetApplyProductsId(): self
    {
        $this->instance->unsetApplyProductsId();
        return $this;
    }

    /**
     * Sets exclude products id field.
     */
    public function excludeProductsId(?string $value): self
    {
        $this->instance->setExcludeProductsId($value);
        return $this;
    }

    /**
     * Unsets exclude products id field.
     */
    public function unsetExcludeProductsId(): self
    {
        $this->instance->unsetExcludeProductsId();
        return $this;
    }

    /**
     * Sets valid from date field.
     */
    public function validFromDate(?string $value): self
    {
        $this->instance->setValidFromDate($value);
        return $this;
    }

    /**
     * Unsets valid from date field.
     */
    public function unsetValidFromDate(): self
    {
        $this->instance->unsetValidFromDate();
        return $this;
    }

    /**
     * Sets valid from local time field.
     */
    public function validFromLocalTime(?string $value): self
    {
        $this->instance->setValidFromLocalTime($value);
        return $this;
    }

    /**
     * Unsets valid from local time field.
     */
    public function unsetValidFromLocalTime(): self
    {
        $this->instance->unsetValidFromLocalTime();
        return $this;
    }

    /**
     * Sets valid until date field.
     */
    public function validUntilDate(?string $value): self
    {
        $this->instance->setValidUntilDate($value);
        return $this;
    }

    /**
     * Unsets valid until date field.
     */
    public function unsetValidUntilDate(): self
    {
        $this->instance->unsetValidUntilDate();
        return $this;
    }

    /**
     * Sets valid until local time field.
     */
    public function validUntilLocalTime(?string $value): self
    {
        $this->instance->setValidUntilLocalTime($value);
        return $this;
    }

    /**
     * Unsets valid until local time field.
     */
    public function unsetValidUntilLocalTime(): self
    {
        $this->instance->unsetValidUntilLocalTime();
        return $this;
    }

    /**
     * Sets exclude strategy field.
     */
    public function excludeStrategy(?string $value): self
    {
        $this->instance->setExcludeStrategy($value);
        return $this;
    }

    /**
     * Sets minimum order subtotal money field.
     */
    public function minimumOrderSubtotalMoney(?Money $value): self
    {
        $this->instance->setMinimumOrderSubtotalMoney($value);
        return $this;
    }

    /**
     * Sets customer group ids any field.
     */
    public function customerGroupIdsAny(?array $value): self
    {
        $this->instance->setCustomerGroupIdsAny($value);
        return $this;
    }

    /**
     * Unsets customer group ids any field.
     */
    public function unsetCustomerGroupIdsAny(): self
    {
        $this->instance->unsetCustomerGroupIdsAny();
        return $this;
    }

    /**
     * Initializes a new catalog pricing rule object.
     */
    public function build(): CatalogPricingRule
    {
        return CoreHelper::clone($this->instance);
    }
}
