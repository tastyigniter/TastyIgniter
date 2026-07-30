<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents additional data for rules with the `SPEND` accrual type.
 */
class LoyaltyProgramAccrualRuleSpendData implements \JsonSerializable
{
    /**
     * @var Money
     */
    private $amountMoney;

    /**
     * @var array
     */
    private $excludedCategoryIds = [];

    /**
     * @var array
     */
    private $excludedItemVariationIds = [];

    /**
     * @var string
     */
    private $taxMode;

    /**
     * @param Money $amountMoney
     * @param string $taxMode
     */
    public function __construct(Money $amountMoney, string $taxMode)
    {
        $this->amountMoney = $amountMoney;
        $this->taxMode = $taxMode;
    }

    /**
     * Returns Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @required
     * @maps amount_money
     */
    public function setAmountMoney(Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Excluded Category Ids.
     * The IDs of any `CATEGORY` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded categories.
     *
     * @return string[]|null
     */
    public function getExcludedCategoryIds(): ?array
    {
        if (count($this->excludedCategoryIds) == 0) {
            return null;
        }
        return $this->excludedCategoryIds['value'];
    }

    /**
     * Sets Excluded Category Ids.
     * The IDs of any `CATEGORY` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded categories.
     *
     * @maps excluded_category_ids
     *
     * @param string[]|null $excludedCategoryIds
     */
    public function setExcludedCategoryIds(?array $excludedCategoryIds): void
    {
        $this->excludedCategoryIds['value'] = $excludedCategoryIds;
    }

    /**
     * Unsets Excluded Category Ids.
     * The IDs of any `CATEGORY` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded categories.
     */
    public function unsetExcludedCategoryIds(): void
    {
        $this->excludedCategoryIds = [];
    }

    /**
     * Returns Excluded Item Variation Ids.
     * The IDs of any `ITEM_VARIATION` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded item variations.
     *
     * @return string[]|null
     */
    public function getExcludedItemVariationIds(): ?array
    {
        if (count($this->excludedItemVariationIds) == 0) {
            return null;
        }
        return $this->excludedItemVariationIds['value'];
    }

    /**
     * Sets Excluded Item Variation Ids.
     * The IDs of any `ITEM_VARIATION` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded item variations.
     *
     * @maps excluded_item_variation_ids
     *
     * @param string[]|null $excludedItemVariationIds
     */
    public function setExcludedItemVariationIds(?array $excludedItemVariationIds): void
    {
        $this->excludedItemVariationIds['value'] = $excludedItemVariationIds;
    }

    /**
     * Unsets Excluded Item Variation Ids.
     * The IDs of any `ITEM_VARIATION` catalog objects that are excluded from points accrual.
     *
     * You can use the [BatchRetrieveCatalogObjects](api-endpoint:Catalog-BatchRetrieveCatalogObjects)
     * endpoint to retrieve information about the excluded item variations.
     */
    public function unsetExcludedItemVariationIds(): void
    {
        $this->excludedItemVariationIds = [];
    }

    /**
     * Returns Tax Mode.
     * Indicates how taxes should be treated when calculating the purchase amount used for loyalty points
     * accrual.
     * This setting applies only to `SPEND` accrual rules or `VISIT` accrual rules that have a minimum
     * spend requirement.
     */
    public function getTaxMode(): string
    {
        return $this->taxMode;
    }

    /**
     * Sets Tax Mode.
     * Indicates how taxes should be treated when calculating the purchase amount used for loyalty points
     * accrual.
     * This setting applies only to `SPEND` accrual rules or `VISIT` accrual rules that have a minimum
     * spend requirement.
     *
     * @required
     * @maps tax_mode
     */
    public function setTaxMode(string $taxMode): void
    {
        $this->taxMode = $taxMode;
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
        $json['amount_money']                    = $this->amountMoney;
        if (!empty($this->excludedCategoryIds)) {
            $json['excluded_category_ids']       = $this->excludedCategoryIds['value'];
        }
        if (!empty($this->excludedItemVariationIds)) {
            $json['excluded_item_variation_ids'] = $this->excludedItemVariationIds['value'];
        }
        $json['tax_mode']                        = $this->taxMode;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
