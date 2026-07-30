<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Possible types of CatalogObjects returned from the catalog, each
 * containing type-specific properties in the `*_data` field corresponding to the specfied object type.
 */
class CatalogObjectType
{
    /**
     * The `CatalogObject` instance is of the [CatalogItem]($m/CatalogItem) type and represents an item.
     * The item-specific data
     * must be set on the `item_data` field.
     */
    public const ITEM = 'ITEM';

    /**
     * The `CatalogObject` instance is of the [CatalogImage]($m/CatalogImage) type and represents an image.
     * The image-specific data
     * must be set on the `image_data` field.
     */
    public const IMAGE = 'IMAGE';

    /**
     * The `CatalogObject` instance is of the [CatalogCategory]($m/CatalogCategory) type and represents a
     * category. The category-specific data
     * must be set on the `category_data` field.
     */
    public const CATEGORY = 'CATEGORY';

    /**
     * The `CatalogObject` instance is of the  [CatalogItemVariation]($m/CatalogItemVariation) type and
     * represents an item variation, also referred to as variation.
     * The item variation-specific data must be set on the `item_variation_data` field.
     */
    public const ITEM_VARIATION = 'ITEM_VARIATION';

    /**
     * The `CatalogObject` instance is of the [CatalogTax]($m/CatalogTax) type and represents a tax. The
     * tax-specific data
     * must be set on the `tax_data` field.
     */
    public const TAX = 'TAX';

    /**
     * The `CatalogObject` instance is of the [CatalogDiscount]($m/CatalogDiscount) type and represents a
     * discount. The discount-specific data
     * must be set on the `discount_data` field.
     */
    public const DISCOUNT = 'DISCOUNT';

    /**
     * The `CatalogObject` instance is of the [CatalogModifierList]($m/CatalogModifierList) type and
     * represents a modifier list.
     * The modifier-list-specific data must be set on the `modifier_list_data` field.
     */
    public const MODIFIER_LIST = 'MODIFIER_LIST';

    /**
     * The `CatalogObject` instance is of the [CatalogModifier]($m/CatalogModifier) type and represents a
     * modifier. The modifier-specific data
     * must be set on the `modifier_data` field.
     */
    public const MODIFIER = 'MODIFIER';

    /**
     * The `CatalogObject` instance is of the [CatalogPricingRule]($m/CatalogPricingRule) type and
     * represents a pricing rule. The pricing-rule-specific data
     * must be set on the `pricing_rule_data` field.
     */
    public const PRICING_RULE = 'PRICING_RULE';

    /**
     * The `CatalogObject` instance is of the [CatalogProductSet]($m/CatalogProductSet) type and represents
     * a product set.
     * The product-set-specific data will be stored in the `product_set_data` field.
     */
    public const PRODUCT_SET = 'PRODUCT_SET';

    /**
     * The `CatalogObject` instance is of the [CatalogTimePeriod]($m/CatalogTimePeriod) type and represents
     * a time period.
     * The time-period-specific data must be set on the `time_period_data` field.
     */
    public const TIME_PERIOD = 'TIME_PERIOD';

    /**
     * The `CatalogObject` instance is of the [CatalogMeasurementUnit]($m/CatalogMeasurementUnit) type and
     * represents a measurement unit specifying the unit of
     * measure and precision in which an item variation is sold. The measurement-unit-specific data must
     * set on the `measurement_unit_data` field.
     */
    public const MEASUREMENT_UNIT = 'MEASUREMENT_UNIT';

    /**
     * The `CatalogObject` instance is of the [CatalogItemOption]($m/CatalogItemOption) type and represents
     * a list of options (such as a color or size of a T-shirt)
     * that can be assigned to item variations. The item-option-specific data must be on the
     * `item_option_data` field.
     */
    public const ITEM_OPTION = 'ITEM_OPTION';

    /**
     * The `CatalogObject` instance is of the [CatalogItemOptionValue]($m/CatalogItemOptionValue) type and
     * represents a value associated with one or more item options.
     * For example, an item option of "Size" may have item option values such as "Small" or "Medium".
     * The item-option-value-specific data must be on the `item_option_value_data` field.
     */
    public const ITEM_OPTION_VAL = 'ITEM_OPTION_VAL';

    /**
     * The `CatalogObject` instance is of the
     * [CatalogCustomAttributeDefinition]($m/CatalogCustomAttributeDefinition) type and represents the
     * definition of a custom attribute.
     * The custom-attribute-definition-specific data must be set on the `custom_attribute_definition_data`
     * field.
     */
    public const CUSTOM_ATTRIBUTE_DEFINITION = 'CUSTOM_ATTRIBUTE_DEFINITION';

    /**
     * The `CatalogObject` instance is of the [CatalogQuickAmountsSettings]($m/CatalogQuickAmountsSettings)
     * type and represents settings to configure preset charges for quick payments at each location.
     * For example, a location may have a list of both AUTO and MANUAL quick amounts that are set to
     * DISABLED.
     * The quick-amounts-settings-specific data must be set on the `quick_amounts_settings_data` field.
     */
    public const QUICK_AMOUNTS_SETTINGS = 'QUICK_AMOUNTS_SETTINGS';

    /**
     * The `CatalogObject` instance is of the [CatalogSubscriptionPlan]($m/CatalogSubscriptionPlan) type
     * and represents a subscription plan.
     * The subscription plan specific data must be stored on the `subscription_plan_data` field.
     */
    public const SUBSCRIPTION_PLAN = 'SUBSCRIPTION_PLAN';
}
