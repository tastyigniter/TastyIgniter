
# Catalog Object Type

Possible types of CatalogObjects returned from the catalog, each
containing type-specific properties in the `*_data` field corresponding to the specfied object type.

## Enumeration

`CatalogObjectType`

## Fields

| Name | Description |
|  --- | --- |
| `ITEM` | The `CatalogObject` instance is of the [CatalogItem](../../doc/models/catalog-item.md) type and represents an item. The item-specific data<br>must be set on the `item_data` field. |
| `IMAGE` | The `CatalogObject` instance is of the [CatalogImage](../../doc/models/catalog-image.md) type and represents an image. The image-specific data<br>must be set on the `image_data` field. |
| `CATEGORY` | The `CatalogObject` instance is of the [CatalogCategory](../../doc/models/catalog-category.md) type and represents a category. The category-specific data<br>must be set on the `category_data` field. |
| `ITEM_VARIATION` | The `CatalogObject` instance is of the  [CatalogItemVariation](../../doc/models/catalog-item-variation.md) type and represents an item variation, also referred to as variation.<br>The item variation-specific data must be set on the `item_variation_data` field. |
| `TAX` | The `CatalogObject` instance is of the [CatalogTax](../../doc/models/catalog-tax.md) type and represents a tax. The tax-specific data<br>must be set on the `tax_data` field. |
| `DISCOUNT` | The `CatalogObject` instance is of the [CatalogDiscount](../../doc/models/catalog-discount.md) type and represents a discount. The discount-specific data<br>must be set on the `discount_data` field. |
| `MODIFIER_LIST` | The `CatalogObject` instance is of the [CatalogModifierList](../../doc/models/catalog-modifier-list.md) type and represents a modifier list.<br>The modifier-list-specific data must be set on the `modifier_list_data` field. |
| `MODIFIER` | The `CatalogObject` instance is of the [CatalogModifier](../../doc/models/catalog-modifier.md) type and represents a modifier. The modifier-specific data<br>must be set on the `modifier_data` field. |
| `PRICING_RULE` | The `CatalogObject` instance is of the [CatalogPricingRule](../../doc/models/catalog-pricing-rule.md) type and represents a pricing rule. The pricing-rule-specific data<br>must be set on the `pricing_rule_data` field. |
| `PRODUCT_SET` | The `CatalogObject` instance is of the [CatalogProductSet](../../doc/models/catalog-product-set.md) type and represents a product set.<br>The product-set-specific data will be stored in the `product_set_data` field. |
| `TIME_PERIOD` | The `CatalogObject` instance is of the [CatalogTimePeriod](../../doc/models/catalog-time-period.md) type and represents a time period.<br>The time-period-specific data must be set on the `time_period_data` field. |
| `MEASUREMENT_UNIT` | The `CatalogObject` instance is of the [CatalogMeasurementUnit](../../doc/models/catalog-measurement-unit.md) type and represents a measurement unit specifying the unit of<br>measure and precision in which an item variation is sold. The measurement-unit-specific data must set on the `measurement_unit_data` field. |
| `ITEM_OPTION` | The `CatalogObject` instance is of the [CatalogItemOption](../../doc/models/catalog-item-option.md) type and represents a list of options (such as a color or size of a T-shirt)<br>that can be assigned to item variations. The item-option-specific data must be on the `item_option_data` field. |
| `ITEM_OPTION_VAL` | The `CatalogObject` instance is of the [CatalogItemOptionValue](../../doc/models/catalog-item-option-value.md) type and represents a value associated with one or more item options.<br>For example, an item option of "Size" may have item option values such as "Small" or "Medium".<br>The item-option-value-specific data must be on the `item_option_value_data` field. |
| `CUSTOM_ATTRIBUTE_DEFINITION` | The `CatalogObject` instance is of the [CatalogCustomAttributeDefinition](../../doc/models/catalog-custom-attribute-definition.md) type and represents the definition of a custom attribute.<br>The custom-attribute-definition-specific data must be set on the `custom_attribute_definition_data` field. |
| `QUICK_AMOUNTS_SETTINGS` | The `CatalogObject` instance is of the [CatalogQuickAmountsSettings](../../doc/models/catalog-quick-amounts-settings.md) type and represents settings to configure preset charges for quick payments at each location.<br>For example, a location may have a list of both AUTO and MANUAL quick amounts that are set to DISABLED.<br>The quick-amounts-settings-specific data must be set on the `quick_amounts_settings_data` field. |
| `SUBSCRIPTION_PLAN` | The `CatalogObject` instance is of the [CatalogSubscriptionPlan](../../doc/models/catalog-subscription-plan.md) type and represents a subscription plan.<br>The subscription plan specific data must be stored on the `subscription_plan_data` field. |

