
# Catalog Object

The wrapper object for the catalog entries of a given object type.

Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to yield the corresponding type of catalog object.

For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.

In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is also a `Catalog<ObjectType>` instance.

For a more detailed discussion of the Catalog data model, please see the
[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide.

## Structure

`CatalogObject`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `type` | [`string (CatalogObjectType)`](../../doc/models/catalog-object-type.md) | Required | Possible types of CatalogObjects returned from the catalog, each<br>containing type-specific properties in the `*_data` field corresponding to the specfied object type. | getType(): string | setType(string type): void |
| `id` | `string` | Required | An identifier to reference this object in the catalog. When a new `CatalogObject`<br>is inserted, the client should set the id to a temporary identifier starting with<br>a "`#`" character. Other objects being inserted or updated within the same request<br>may use this identifier to refer to the new object.<br><br>When the server receives the new object, it will supply a unique identifier that<br>replaces the temporary identifier for all future references.<br>**Constraints**: *Minimum Length*: `1` | getId(): string | setId(string id): void |
| `updatedAt` | `?string` | Optional | Last modification [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates) in RFC 3339 format, e.g., `"2016-08-15T23:59:33.123Z"`<br>would indicate the UTC time (denoted by `Z`) of August 15, 2016 at 23:59:33 and 123 milliseconds. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `version` | `?int` | Optional | The version of the object. When updating an object, the version supplied<br>must match the version in the database, otherwise the write will be rejected as conflicting. | getVersion(): ?int | setVersion(?int version): void |
| `isDeleted` | `?bool` | Optional | If `true`, the object has been deleted from the database. Must be `false` for new objects<br>being inserted. When deleted, the `updated_at` field will equal the deletion time. | getIsDeleted(): ?bool | setIsDeleted(?bool isDeleted): void |
| `customAttributeValues` | [`?array<string,CatalogCustomAttributeValue>`](../../doc/models/catalog-custom-attribute-value.md) | Optional | A map (key-value pairs) of application-defined custom attribute values. The value of a key-value pair<br>is a [CatalogCustomAttributeValue](entity:CatalogCustomAttributeValue) object. The key is the `key` attribute<br>value defined in the associated [CatalogCustomAttributeDefinition](entity:CatalogCustomAttributeDefinition)<br>object defined by the application making the request.<br><br>If the `CatalogCustomAttributeDefinition` object is<br>defined by another application, the `CatalogCustomAttributeDefinition`'s key attribute value is prefixed by<br>the defining application ID. For example, if the `CatalogCustomAttributeDefinition` has a `key` attribute of<br>`"cocoa_brand"` and the defining application ID is `"abcd1234"`, the key in the map is `"abcd1234:cocoa_brand"`<br>if the application making the request is different from the application defining the custom attribute definition.<br>Otherwise, the key used in the map is simply `"cocoa_brand"`.<br><br>Application-defined custom attributes are set at a global (location-independent) level.<br>Custom attribute values are intended to store additional information about a catalog object<br>or associations with an entity in another system. Do not use custom attributes<br>to store any sensitive information (personally identifiable information, card details, etc.). | getCustomAttributeValues(): ?array | setCustomAttributeValues(?array customAttributeValues): void |
| `catalogV1Ids` | [`?(CatalogV1Id[])`](../../doc/models/catalog-v1-id.md) | Optional | The Connect v1 IDs for this object at each location where it is present, where they<br>differ from the object's Connect V2 ID. The field will only be present for objects that<br>have been created or modified by legacy APIs. | getCatalogV1Ids(): ?array | setCatalogV1Ids(?array catalogV1Ids): void |
| `presentAtAllLocations` | `?bool` | Optional | If `true`, this object is present at all locations (including future locations), except where specified in<br>the `absent_at_location_ids` field. If `false`, this object is not present at any locations (including future locations),<br>except where specified in the `present_at_location_ids` field. If not specified, defaults to `true`. | getPresentAtAllLocations(): ?bool | setPresentAtAllLocations(?bool presentAtAllLocations): void |
| `presentAtLocationIds` | `?(string[])` | Optional | A list of locations where the object is present, even if `present_at_all_locations` is `false`.<br>This can include locations that are deactivated. | getPresentAtLocationIds(): ?array | setPresentAtLocationIds(?array presentAtLocationIds): void |
| `absentAtLocationIds` | `?(string[])` | Optional | A list of locations where the object is not present, even if `present_at_all_locations` is `true`.<br>This can include locations that are deactivated. | getAbsentAtLocationIds(): ?array | setAbsentAtLocationIds(?array absentAtLocationIds): void |
| `itemData` | [`?CatalogItem`](../../doc/models/catalog-item.md) | Optional | A [CatalogObject](../../doc/models/catalog-object.md) instance of the `ITEM` type, also referred to as an item, in the catalog. | getItemData(): ?CatalogItem | setItemData(?CatalogItem itemData): void |
| `categoryData` | [`?CatalogCategory`](../../doc/models/catalog-category.md) | Optional | A category to which a `CatalogItem` instance belongs. | getCategoryData(): ?CatalogCategory | setCategoryData(?CatalogCategory categoryData): void |
| `itemVariationData` | [`?CatalogItemVariation`](../../doc/models/catalog-item-variation.md) | Optional | An item variation, representing a product for sale, in the Catalog object model. Each [item](../../doc/models/catalog-item.md) must have at least one<br>item variation and can have at most 250 item variations.<br><br>An item variation can be sellable, stockable, or both if it has a unit of measure for its count for the sold number of the variation, the stocked<br>number of the variation, or both. For example, when a variation representing wine is stocked and sold by the bottle, the variation is both<br>stockable and sellable. But when a variation of the wine is sold by the glass, the sold units cannot be used as a measure of the stocked units. This by-the-glass<br>variation is sellable, but not stockable. To accurately keep track of the wine's inventory count at any time, the sellable count must be<br>converted to stockable count. Typically, the seller defines this unit conversion. For example, 1 bottle equals 5 glasses. The Square API exposes<br>the `stockable_conversion` property on the variation to specify the conversion. Thus, when two glasses of the wine are sold, the sellable count<br>decreases by 2, and the stockable count automatically decreases by 0.4 bottle according to the conversion. | getItemVariationData(): ?CatalogItemVariation | setItemVariationData(?CatalogItemVariation itemVariationData): void |
| `taxData` | [`?CatalogTax`](../../doc/models/catalog-tax.md) | Optional | A tax applicable to an item. | getTaxData(): ?CatalogTax | setTaxData(?CatalogTax taxData): void |
| `discountData` | [`?CatalogDiscount`](../../doc/models/catalog-discount.md) | Optional | A discount applicable to items. | getDiscountData(): ?CatalogDiscount | setDiscountData(?CatalogDiscount discountData): void |
| `modifierListData` | [`?CatalogModifierList`](../../doc/models/catalog-modifier-list.md) | Optional | A list of modifiers applicable to items at the time of sale.<br><br>For example, a "Condiments" modifier list applicable to a "Hot Dog" item<br>may contain "Ketchup", "Mustard", and "Relish" modifiers.<br>Use the `selection_type` field to specify whether or not multiple selections from<br>the modifier list are allowed. | getModifierListData(): ?CatalogModifierList | setModifierListData(?CatalogModifierList modifierListData): void |
| `modifierData` | [`?CatalogModifier`](../../doc/models/catalog-modifier.md) | Optional | A modifier applicable to items at the time of sale. | getModifierData(): ?CatalogModifier | setModifierData(?CatalogModifier modifierData): void |
| `timePeriodData` | [`?CatalogTimePeriod`](../../doc/models/catalog-time-period.md) | Optional | Represents a time period - either a single period or a repeating period. | getTimePeriodData(): ?CatalogTimePeriod | setTimePeriodData(?CatalogTimePeriod timePeriodData): void |
| `productSetData` | [`?CatalogProductSet`](../../doc/models/catalog-product-set.md) | Optional | Represents a collection of catalog objects for the purpose of applying a<br>`PricingRule`. Including a catalog object will include all of its subtypes.<br>For example, including a category in a product set will include all of its<br>items and associated item variations in the product set. Including an item in<br>a product set will also include its item variations. | getProductSetData(): ?CatalogProductSet | setProductSetData(?CatalogProductSet productSetData): void |
| `pricingRuleData` | [`?CatalogPricingRule`](../../doc/models/catalog-pricing-rule.md) | Optional | Defines how discounts are automatically applied to a set of items that match the pricing rule<br>during the active time period. | getPricingRuleData(): ?CatalogPricingRule | setPricingRuleData(?CatalogPricingRule pricingRuleData): void |
| `imageData` | [`?CatalogImage`](../../doc/models/catalog-image.md) | Optional | An image file to use in Square catalogs. It can be associated with<br>`CatalogItem`, `CatalogItemVariation`, `CatalogCategory`, and `CatalogModifierList` objects.<br>Only the images on items and item variations are exposed in Dashboard.<br>Only the first image on an item is displayed in Square Point of Sale (SPOS).<br>Images on items and variations are displayed through Square Online Store.<br>Images on other object types are for use by 3rd party application developers. | getImageData(): ?CatalogImage | setImageData(?CatalogImage imageData): void |
| `measurementUnitData` | [`?CatalogMeasurementUnit`](../../doc/models/catalog-measurement-unit.md) | Optional | Represents the unit used to measure a `CatalogItemVariation` and<br>specifies the precision for decimal quantities. | getMeasurementUnitData(): ?CatalogMeasurementUnit | setMeasurementUnitData(?CatalogMeasurementUnit measurementUnitData): void |
| `subscriptionPlanData` | [`?CatalogSubscriptionPlan`](../../doc/models/catalog-subscription-plan.md) | Optional | Describes a subscription plan. For more information, see<br>[Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-plan). | getSubscriptionPlanData(): ?CatalogSubscriptionPlan | setSubscriptionPlanData(?CatalogSubscriptionPlan subscriptionPlanData): void |
| `itemOptionData` | [`?CatalogItemOption`](../../doc/models/catalog-item-option.md) | Optional | A group of variations for a `CatalogItem`. | getItemOptionData(): ?CatalogItemOption | setItemOptionData(?CatalogItemOption itemOptionData): void |
| `itemOptionValueData` | [`?CatalogItemOptionValue`](../../doc/models/catalog-item-option-value.md) | Optional | An enumerated value that can link a<br>`CatalogItemVariation` to an item option as one of<br>its item option values. | getItemOptionValueData(): ?CatalogItemOptionValue | setItemOptionValueData(?CatalogItemOptionValue itemOptionValueData): void |
| `customAttributeDefinitionData` | [`?CatalogCustomAttributeDefinition`](../../doc/models/catalog-custom-attribute-definition.md) | Optional | Contains information defining a custom attribute. Custom attributes are<br>intended to store additional information about a catalog object or to associate a<br>catalog object with an entity in another system. Do not use custom attributes<br>to store any sensitive information (personally identifiable information, card details, etc.).<br>[Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-attributes) | getCustomAttributeDefinitionData(): ?CatalogCustomAttributeDefinition | setCustomAttributeDefinitionData(?CatalogCustomAttributeDefinition customAttributeDefinitionData): void |
| `quickAmountsSettingsData` | [`?CatalogQuickAmountsSettings`](../../doc/models/catalog-quick-amounts-settings.md) | Optional | A parent Catalog Object model represents a set of Quick Amounts and the settings control the amounts. | getQuickAmountsSettingsData(): ?CatalogQuickAmountsSettings | setQuickAmountsSettingsData(?CatalogQuickAmountsSettings quickAmountsSettingsData): void |

## Example (as JSON)

```json
{
  "type": null,
  "id": null,
  "item_data": {
    "object": {
      "id": "#Cocoa",
      "item_data": {
        "abbreviation": "Ch",
        "description": "Hot chocolate",
        "name": "Cocoa",
        "visibility": "PRIVATE"
      },
      "present_at_all_locations": true,
      "type": "ITEM"
    }
  },
  "category_data": {
    "object": {
      "category_data": {
        "name": "Beverages"
      },
      "id": "#Beverages",
      "present_at_all_locations": true,
      "type": "CATEGORY"
    }
  },
  "tax_data": {
    "object": {
      "id": "#SalesTax",
      "present_at_all_locations": true,
      "tax_data": {
        "calculation_phase": "TAX_SUBTOTAL_PHASE",
        "enabled": true,
        "fee_applies_to_custom_amounts": true,
        "inclusion_type": "ADDITIVE",
        "name": "Sales Tax",
        "percentage": "5.0"
      },
      "type": "TAX"
    }
  },
  "discount_data": {
    "object": {
      "discount_data": {
        "discount_type": "FIXED_PERCENTAGE",
        "label_color": "red",
        "name": "Welcome to the Dark(Roast) Side!",
        "percentage": "5.4",
        "pin_required": false
      },
      "id": "#Maythe4th",
      "present_at_all_locations": true,
      "type": "DISCOUNT"
    }
  },
  "modifier_list_data": {
    "id": "#MilkType",
    "modifier_list_data": {
      "allow_quantities": false,
      "modifiers": [
        {
          "modifier_data": {
            "name": "Whole Milk",
            "price_money": {
              "amount": 0,
              "currency": "USD"
            }
          },
          "present_at_all_locations": true,
          "type": "MODIFIER"
        },
        {
          "modifier_data": {
            "name": "Almond Milk",
            "price_money": {
              "amount": 250,
              "currency": "USD"
            }
          },
          "present_at_all_locations": true,
          "type": "MODIFIER"
        },
        {
          "modifier_data": {
            "name": "Soy Milk",
            "price_money": {
              "amount": 250,
              "currency": "USD"
            }
          },
          "present_at_all_locations": true,
          "type": "MODIFIER"
        }
      ],
      "name": "Milk Type",
      "selection_type": "SINGLE"
    },
    "present_at_all_locations": true,
    "type": "MODIFIER_LIST"
  },
  "modifier_data": {
    "object": {
      "modifier_data": {
        "name": "Almond Milk",
        "price_money": {
          "amount": 250,
          "currency": "USD"
        }
      },
      "present_at_all_locations": true,
      "type": "MODIFIER"
    }
  }
}
```

