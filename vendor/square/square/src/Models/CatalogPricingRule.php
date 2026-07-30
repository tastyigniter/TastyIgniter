<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines how discounts are automatically applied to a set of items that match the pricing rule
 * during the active time period.
 */
class CatalogPricingRule implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $timePeriodIds = [];

    /**
     * @var array
     */
    private $discountId = [];

    /**
     * @var array
     */
    private $matchProductsId = [];

    /**
     * @var array
     */
    private $applyProductsId = [];

    /**
     * @var array
     */
    private $excludeProductsId = [];

    /**
     * @var array
     */
    private $validFromDate = [];

    /**
     * @var array
     */
    private $validFromLocalTime = [];

    /**
     * @var array
     */
    private $validUntilDate = [];

    /**
     * @var array
     */
    private $validUntilLocalTime = [];

    /**
     * @var string|null
     */
    private $excludeStrategy;

    /**
     * @var Money|null
     */
    private $minimumOrderSubtotalMoney;

    /**
     * @var array
     */
    private $customerGroupIdsAny = [];

    /**
     * Returns Name.
     * User-defined name for the pricing rule. For example, "Buy one get one
     * free" or "10% off".
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * User-defined name for the pricing rule. For example, "Buy one get one
     * free" or "10% off".
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * User-defined name for the pricing rule. For example, "Buy one get one
     * free" or "10% off".
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Time Period Ids.
     * A list of unique IDs for the catalog time periods when
     * this pricing rule is in effect. If left unset, the pricing rule is always
     * in effect.
     *
     * @return string[]|null
     */
    public function getTimePeriodIds(): ?array
    {
        if (count($this->timePeriodIds) == 0) {
            return null;
        }
        return $this->timePeriodIds['value'];
    }

    /**
     * Sets Time Period Ids.
     * A list of unique IDs for the catalog time periods when
     * this pricing rule is in effect. If left unset, the pricing rule is always
     * in effect.
     *
     * @maps time_period_ids
     *
     * @param string[]|null $timePeriodIds
     */
    public function setTimePeriodIds(?array $timePeriodIds): void
    {
        $this->timePeriodIds['value'] = $timePeriodIds;
    }

    /**
     * Unsets Time Period Ids.
     * A list of unique IDs for the catalog time periods when
     * this pricing rule is in effect. If left unset, the pricing rule is always
     * in effect.
     */
    public function unsetTimePeriodIds(): void
    {
        $this->timePeriodIds = [];
    }

    /**
     * Returns Discount Id.
     * Unique ID for the `CatalogDiscount` to take off
     * the price of all matched items.
     */
    public function getDiscountId(): ?string
    {
        if (count($this->discountId) == 0) {
            return null;
        }
        return $this->discountId['value'];
    }

    /**
     * Sets Discount Id.
     * Unique ID for the `CatalogDiscount` to take off
     * the price of all matched items.
     *
     * @maps discount_id
     */
    public function setDiscountId(?string $discountId): void
    {
        $this->discountId['value'] = $discountId;
    }

    /**
     * Unsets Discount Id.
     * Unique ID for the `CatalogDiscount` to take off
     * the price of all matched items.
     */
    public function unsetDiscountId(): void
    {
        $this->discountId = [];
    }

    /**
     * Returns Match Products Id.
     * Unique ID for the `CatalogProductSet` that will be matched by this rule. A match rule
     * matches within the entire cart, and can match multiple times. This field will always be set.
     */
    public function getMatchProductsId(): ?string
    {
        if (count($this->matchProductsId) == 0) {
            return null;
        }
        return $this->matchProductsId['value'];
    }

    /**
     * Sets Match Products Id.
     * Unique ID for the `CatalogProductSet` that will be matched by this rule. A match rule
     * matches within the entire cart, and can match multiple times. This field will always be set.
     *
     * @maps match_products_id
     */
    public function setMatchProductsId(?string $matchProductsId): void
    {
        $this->matchProductsId['value'] = $matchProductsId;
    }

    /**
     * Unsets Match Products Id.
     * Unique ID for the `CatalogProductSet` that will be matched by this rule. A match rule
     * matches within the entire cart, and can match multiple times. This field will always be set.
     */
    public function unsetMatchProductsId(): void
    {
        $this->matchProductsId = [];
    }

    /**
     * Returns Apply Products Id.
     * __Deprecated__: Please use the `exclude_products_id` field to apply
     * an exclude set instead. Exclude sets allow better control over quantity
     * ranges and offer more flexibility for which matched items receive a discount.
     *
     * `CatalogProductSet` to apply the pricing to.
     * An apply rule matches within the subset of the cart that fits the match rules (the match set).
     * An apply rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     */
    public function getApplyProductsId(): ?string
    {
        if (count($this->applyProductsId) == 0) {
            return null;
        }
        return $this->applyProductsId['value'];
    }

    /**
     * Sets Apply Products Id.
     * __Deprecated__: Please use the `exclude_products_id` field to apply
     * an exclude set instead. Exclude sets allow better control over quantity
     * ranges and offer more flexibility for which matched items receive a discount.
     *
     * `CatalogProductSet` to apply the pricing to.
     * An apply rule matches within the subset of the cart that fits the match rules (the match set).
     * An apply rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     *
     * @maps apply_products_id
     */
    public function setApplyProductsId(?string $applyProductsId): void
    {
        $this->applyProductsId['value'] = $applyProductsId;
    }

    /**
     * Unsets Apply Products Id.
     * __Deprecated__: Please use the `exclude_products_id` field to apply
     * an exclude set instead. Exclude sets allow better control over quantity
     * ranges and offer more flexibility for which matched items receive a discount.
     *
     * `CatalogProductSet` to apply the pricing to.
     * An apply rule matches within the subset of the cart that fits the match rules (the match set).
     * An apply rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     */
    public function unsetApplyProductsId(): void
    {
        $this->applyProductsId = [];
    }

    /**
     * Returns Exclude Products Id.
     * `CatalogProductSet` to exclude from the pricing rule.
     * An exclude rule matches within the subset of the cart that fits the match rules (the match set).
     * An exclude rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     */
    public function getExcludeProductsId(): ?string
    {
        if (count($this->excludeProductsId) == 0) {
            return null;
        }
        return $this->excludeProductsId['value'];
    }

    /**
     * Sets Exclude Products Id.
     * `CatalogProductSet` to exclude from the pricing rule.
     * An exclude rule matches within the subset of the cart that fits the match rules (the match set).
     * An exclude rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     *
     * @maps exclude_products_id
     */
    public function setExcludeProductsId(?string $excludeProductsId): void
    {
        $this->excludeProductsId['value'] = $excludeProductsId;
    }

    /**
     * Unsets Exclude Products Id.
     * `CatalogProductSet` to exclude from the pricing rule.
     * An exclude rule matches within the subset of the cart that fits the match rules (the match set).
     * An exclude rule can only match once in the match set.
     * If not supplied, the pricing will be applied to all products in the match set.
     * Other products retain their base price, or a price generated by other rules.
     */
    public function unsetExcludeProductsId(): void
    {
        $this->excludeProductsId = [];
    }

    /**
     * Returns Valid From Date.
     * Represents the date the Pricing Rule is valid from. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     */
    public function getValidFromDate(): ?string
    {
        if (count($this->validFromDate) == 0) {
            return null;
        }
        return $this->validFromDate['value'];
    }

    /**
     * Sets Valid From Date.
     * Represents the date the Pricing Rule is valid from. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     *
     * @maps valid_from_date
     */
    public function setValidFromDate(?string $validFromDate): void
    {
        $this->validFromDate['value'] = $validFromDate;
    }

    /**
     * Unsets Valid From Date.
     * Represents the date the Pricing Rule is valid from. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     */
    public function unsetValidFromDate(): void
    {
        $this->validFromDate = [];
    }

    /**
     * Returns Valid From Local Time.
     * Represents the local time the pricing rule should be valid from. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     */
    public function getValidFromLocalTime(): ?string
    {
        if (count($this->validFromLocalTime) == 0) {
            return null;
        }
        return $this->validFromLocalTime['value'];
    }

    /**
     * Sets Valid From Local Time.
     * Represents the local time the pricing rule should be valid from. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     *
     * @maps valid_from_local_time
     */
    public function setValidFromLocalTime(?string $validFromLocalTime): void
    {
        $this->validFromLocalTime['value'] = $validFromLocalTime;
    }

    /**
     * Unsets Valid From Local Time.
     * Represents the local time the pricing rule should be valid from. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     */
    public function unsetValidFromLocalTime(): void
    {
        $this->validFromLocalTime = [];
    }

    /**
     * Returns Valid Until Date.
     * Represents the date the Pricing Rule is valid until. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     */
    public function getValidUntilDate(): ?string
    {
        if (count($this->validUntilDate) == 0) {
            return null;
        }
        return $this->validUntilDate['value'];
    }

    /**
     * Sets Valid Until Date.
     * Represents the date the Pricing Rule is valid until. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     *
     * @maps valid_until_date
     */
    public function setValidUntilDate(?string $validUntilDate): void
    {
        $this->validUntilDate['value'] = $validUntilDate;
    }

    /**
     * Unsets Valid Until Date.
     * Represents the date the Pricing Rule is valid until. Represented in RFC 3339 full-date format (YYYY-
     * MM-DD).
     */
    public function unsetValidUntilDate(): void
    {
        $this->validUntilDate = [];
    }

    /**
     * Returns Valid Until Local Time.
     * Represents the local time the pricing rule should be valid until. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     */
    public function getValidUntilLocalTime(): ?string
    {
        if (count($this->validUntilLocalTime) == 0) {
            return null;
        }
        return $this->validUntilLocalTime['value'];
    }

    /**
     * Sets Valid Until Local Time.
     * Represents the local time the pricing rule should be valid until. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     *
     * @maps valid_until_local_time
     */
    public function setValidUntilLocalTime(?string $validUntilLocalTime): void
    {
        $this->validUntilLocalTime['value'] = $validUntilLocalTime;
    }

    /**
     * Unsets Valid Until Local Time.
     * Represents the local time the pricing rule should be valid until. Represented in RFC 3339 partial-
     * time format
     * (HH:MM:SS). Partial seconds will be truncated.
     */
    public function unsetValidUntilLocalTime(): void
    {
        $this->validUntilLocalTime = [];
    }

    /**
     * Returns Exclude Strategy.
     * Indicates which products matched by a CatalogPricingRule
     * will be excluded if the pricing rule uses an exclude set.
     */
    public function getExcludeStrategy(): ?string
    {
        return $this->excludeStrategy;
    }

    /**
     * Sets Exclude Strategy.
     * Indicates which products matched by a CatalogPricingRule
     * will be excluded if the pricing rule uses an exclude set.
     *
     * @maps exclude_strategy
     */
    public function setExcludeStrategy(?string $excludeStrategy): void
    {
        $this->excludeStrategy = $excludeStrategy;
    }

    /**
     * Returns Minimum Order Subtotal Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getMinimumOrderSubtotalMoney(): ?Money
    {
        return $this->minimumOrderSubtotalMoney;
    }

    /**
     * Sets Minimum Order Subtotal Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps minimum_order_subtotal_money
     */
    public function setMinimumOrderSubtotalMoney(?Money $minimumOrderSubtotalMoney): void
    {
        $this->minimumOrderSubtotalMoney = $minimumOrderSubtotalMoney;
    }

    /**
     * Returns Customer Group Ids Any.
     * A list of IDs of customer groups, the members of which are eligible for discounts specified in this
     * pricing rule.
     * Notice that a group ID is generated by the Customers API.
     * If this field is not set, the specified discount applies to matched products sold to anyone whether
     * the buyer
     * has a customer profile created or not. If this `customer_group_ids_any` field is set, the specified
     * discount
     * applies only to matched products sold to customers belonging to the specified customer groups.
     *
     * @return string[]|null
     */
    public function getCustomerGroupIdsAny(): ?array
    {
        if (count($this->customerGroupIdsAny) == 0) {
            return null;
        }
        return $this->customerGroupIdsAny['value'];
    }

    /**
     * Sets Customer Group Ids Any.
     * A list of IDs of customer groups, the members of which are eligible for discounts specified in this
     * pricing rule.
     * Notice that a group ID is generated by the Customers API.
     * If this field is not set, the specified discount applies to matched products sold to anyone whether
     * the buyer
     * has a customer profile created or not. If this `customer_group_ids_any` field is set, the specified
     * discount
     * applies only to matched products sold to customers belonging to the specified customer groups.
     *
     * @maps customer_group_ids_any
     *
     * @param string[]|null $customerGroupIdsAny
     */
    public function setCustomerGroupIdsAny(?array $customerGroupIdsAny): void
    {
        $this->customerGroupIdsAny['value'] = $customerGroupIdsAny;
    }

    /**
     * Unsets Customer Group Ids Any.
     * A list of IDs of customer groups, the members of which are eligible for discounts specified in this
     * pricing rule.
     * Notice that a group ID is generated by the Customers API.
     * If this field is not set, the specified discount applies to matched products sold to anyone whether
     * the buyer
     * has a customer profile created or not. If this `customer_group_ids_any` field is set, the specified
     * discount
     * applies only to matched products sold to customers belonging to the specified customer groups.
     */
    public function unsetCustomerGroupIdsAny(): void
    {
        $this->customerGroupIdsAny = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->name)) {
            $json['name']                         = $this->name['value'];
        }
        if (!empty($this->timePeriodIds)) {
            $json['time_period_ids']              = $this->timePeriodIds['value'];
        }
        if (!empty($this->discountId)) {
            $json['discount_id']                  = $this->discountId['value'];
        }
        if (!empty($this->matchProductsId)) {
            $json['match_products_id']            = $this->matchProductsId['value'];
        }
        if (!empty($this->applyProductsId)) {
            $json['apply_products_id']            = $this->applyProductsId['value'];
        }
        if (!empty($this->excludeProductsId)) {
            $json['exclude_products_id']          = $this->excludeProductsId['value'];
        }
        if (!empty($this->validFromDate)) {
            $json['valid_from_date']              = $this->validFromDate['value'];
        }
        if (!empty($this->validFromLocalTime)) {
            $json['valid_from_local_time']        = $this->validFromLocalTime['value'];
        }
        if (!empty($this->validUntilDate)) {
            $json['valid_until_date']             = $this->validUntilDate['value'];
        }
        if (!empty($this->validUntilLocalTime)) {
            $json['valid_until_local_time']       = $this->validUntilLocalTime['value'];
        }
        if (isset($this->excludeStrategy)) {
            $json['exclude_strategy']             = $this->excludeStrategy;
        }
        if (isset($this->minimumOrderSubtotalMoney)) {
            $json['minimum_order_subtotal_money'] = $this->minimumOrderSubtotalMoney;
        }
        if (!empty($this->customerGroupIdsAny)) {
            $json['customer_group_ids_any']       = $this->customerGroupIdsAny['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
