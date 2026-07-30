
# Retrieve Catalog Object Response

## Structure

`RetrieveCatalogObjectResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `object` | [`?CatalogObject`](../../doc/models/catalog-object.md) | Optional | The wrapper object for the catalog entries of a given object type.<br><br>Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to yield the corresponding type of catalog object.<br><br>For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.<br><br>In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is also a `Catalog<ObjectType>` instance.<br><br>For a more detailed discussion of the Catalog data model, please see the<br>[Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide. | getObject(): ?CatalogObject | setObject(?CatalogObject object): void |
| `relatedObjects` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | A list of `CatalogObject`s referenced by the object in the `object` field. | getRelatedObjects(): ?array | setRelatedObjects(?array relatedObjects): void |

## Example (as JSON)

```json
{
  "object": {
    "id": "W62UWFY35CWMYGVWK6TWJDNI",
    "is_deleted": false,
    "item_data": {
      "category_id": "BJNQCF2FJ6S6UIDT65ABHLRX",
      "description": "Hot Leaf Juice",
      "name": "Tea",
      "tax_ids": [
        "HURXQOOAIC4IZSI2BEXQRYFY"
      ],
      "variations": [
        {
          "id": "2TZFAOHWGG7PAK2QEXWYPZSP",
          "is_deleted": false,
          "item_variation_data": {
            "item_id": "W62UWFY35CWMYGVWK6TWJDNI",
            "name": "Mug",
            "ordinal": 0,
            "price_money": {
              "amount": 150,
              "currency": "USD"
            },
            "pricing_type": "FIXED_PRICING"
          },
          "present_at_all_locations": true,
          "type": "ITEM_VARIATION",
          "updated_at": "2016-11-16T22:25:24.878Z",
          "version": 1479335124878
        }
      ]
    },
    "present_at_all_locations": true,
    "type": "ITEM",
    "updated_at": "2016-11-16T22:25:24.878Z",
    "version": 1479335124878
  },
  "related_objects": [
    {
      "category_data": {
        "name": "Beverages"
      },
      "id": "BJNQCF2FJ6S6UIDT65ABHLRX",
      "is_deleted": false,
      "present_at_all_locations": true,
      "type": "CATEGORY",
      "updated_at": "2016-11-16T22:25:24.878Z",
      "version": 1479335124878
    },
    {
      "id": "HURXQOOAIC4IZSI2BEXQRYFY",
      "is_deleted": false,
      "present_at_all_locations": true,
      "tax_data": {
        "calculation_phase": "TAX_SUBTOTAL_PHASE",
        "enabled": true,
        "inclusion_type": "ADDITIVE",
        "name": "Sales Tax",
        "percentage": "5.0"
      },
      "type": "TAX",
      "updated_at": "2016-11-16T22:25:24.878Z",
      "version": 1479335124878
    }
  ]
}
```

