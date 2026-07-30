<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides details about the reward tier discount. DEPRECATED at version 2020-12-16. Discount details
 * are now defined using a catalog pricing rule and other catalog objects. For more information, see
 * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
 * rewards#get-discount-details).
 */
class LoyaltyProgramRewardDefinition implements \JsonSerializable
{
    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $discountType;

    /**
     * @var string|null
     */
    private $percentageDiscount;

    /**
     * @var string[]|null
     */
    private $catalogObjectIds;

    /**
     * @var Money|null
     */
    private $fixedDiscountMoney;

    /**
     * @var Money|null
     */
    private $maxDiscountMoney;

    /**
     * @param string $scope
     * @param string $discountType
     */
    public function __construct(string $scope, string $discountType)
    {
        $this->scope = $scope;
        $this->discountType = $discountType;
    }

    /**
     * Returns Scope.
     * Indicates the scope of the reward tier. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * Sets Scope.
     * Indicates the scope of the reward tier. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     *
     * @required
     * @maps scope
     */
    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * Returns Discount Type.
     * The type of discount the reward tier offers. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     */
    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    /**
     * Sets Discount Type.
     * The type of discount the reward tier offers. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     *
     * @required
     * @maps discount_type
     */
    public function setDiscountType(string $discountType): void
    {
        $this->discountType = $discountType;
    }

    /**
     * Returns Percentage Discount.
     * The fixed percentage of the discount. Present if `discount_type` is `FIXED_PERCENTAGE`.
     * For example, a 7.25% off discount will be represented as "7.25". DEPRECATED at version 2020-12-16.
     * You can find this
     * information in the `discount_data.percentage` field of the `DISCOUNT` catalog object referenced by
     * the pricing rule.
     */
    public function getPercentageDiscount(): ?string
    {
        return $this->percentageDiscount;
    }

    /**
     * Sets Percentage Discount.
     * The fixed percentage of the discount. Present if `discount_type` is `FIXED_PERCENTAGE`.
     * For example, a 7.25% off discount will be represented as "7.25". DEPRECATED at version 2020-12-16.
     * You can find this
     * information in the `discount_data.percentage` field of the `DISCOUNT` catalog object referenced by
     * the pricing rule.
     *
     * @maps percentage_discount
     */
    public function setPercentageDiscount(?string $percentageDiscount): void
    {
        $this->percentageDiscount = $percentageDiscount;
    }

    /**
     * Returns Catalog Object Ids.
     * The list of catalog objects to which this reward can be applied. They are either all item-variation
     * ids or category ids, depending on the `type` field.
     * DEPRECATED at version 2020-12-16. You can find this information in the `product_set_data.
     * product_ids_any` field
     * of the `PRODUCT_SET` catalog object referenced by the pricing rule.
     *
     * @return string[]|null
     */
    public function getCatalogObjectIds(): ?array
    {
        return $this->catalogObjectIds;
    }

    /**
     * Sets Catalog Object Ids.
     * The list of catalog objects to which this reward can be applied. They are either all item-variation
     * ids or category ids, depending on the `type` field.
     * DEPRECATED at version 2020-12-16. You can find this information in the `product_set_data.
     * product_ids_any` field
     * of the `PRODUCT_SET` catalog object referenced by the pricing rule.
     *
     * @maps catalog_object_ids
     *
     * @param string[]|null $catalogObjectIds
     */
    public function setCatalogObjectIds(?array $catalogObjectIds): void
    {
        $this->catalogObjectIds = $catalogObjectIds;
    }

    /**
     * Returns Fixed Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getFixedDiscountMoney(): ?Money
    {
        return $this->fixedDiscountMoney;
    }

    /**
     * Sets Fixed Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps fixed_discount_money
     */
    public function setFixedDiscountMoney(?Money $fixedDiscountMoney): void
    {
        $this->fixedDiscountMoney = $fixedDiscountMoney;
    }

    /**
     * Returns Max Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getMaxDiscountMoney(): ?Money
    {
        return $this->maxDiscountMoney;
    }

    /**
     * Sets Max Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps max_discount_money
     */
    public function setMaxDiscountMoney(?Money $maxDiscountMoney): void
    {
        $this->maxDiscountMoney = $maxDiscountMoney;
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
        $json['scope']                    = $this->scope;
        $json['discount_type']            = $this->discountType;
        if (isset($this->percentageDiscount)) {
            $json['percentage_discount']  = $this->percentageDiscount;
        }
        if (isset($this->catalogObjectIds)) {
            $json['catalog_object_ids']   = $this->catalogObjectIds;
        }
        if (isset($this->fixedDiscountMoney)) {
            $json['fixed_discount_money'] = $this->fixedDiscountMoney;
        }
        if (isset($this->maxDiscountMoney)) {
            $json['max_discount_money']   = $this->maxDiscountMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
