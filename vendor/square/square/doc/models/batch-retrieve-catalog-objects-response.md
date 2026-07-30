
# Batch Retrieve Catalog Objects Response

## Structure

`BatchRetrieveCatalogObjectsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `objects` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | A list of [CatalogObject](entity:CatalogObject)s returned. | getObjects(): ?array | setObjects(?array objects): void |
| `relatedObjects` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | A list of [CatalogObject](entity:CatalogObject)s referenced by the object in the `objects` field. | getRelatedObjects(): ?array | setRelatedObjects(?array relatedObjects): void |

## Example (as JSON)

```json
{
  "objects": [
    {
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
    {
      "id": "AA27W3M2GGTF3H6AVPNB77CK",
      "is_deleted": false,
      "item_data": {
        "category_id": "BJNQCF2FJ6S6UIDT65ABHLRX",
        "description": "Hot Bean Juice",
        "name": "Coffee",
        "tax_ids": [
          "HURXQOOAIC4IZSI2BEXQRYFY"
        ],
        "variations": [
          {
            "id": "LBTYIHNHU52WOIHWT7SNRIYH",
            "is_deleted": false,
            "item_variation_data": {
              "item_id": "AA27W3M2GGTF3H6AVPNB77CK",
              "name": "Regular",
              "ordinal": 0,
              "price_money": {
                "amount": 250,
                "currency": "USD"
              },
              "pricing_type": "FIXED_PRICING"
            },
            "present_at_all_locations": true,
            "type": "ITEM_VARIATION",
            "updated_at": "2016-11-16T22:25:24.878Z",
            "version": 1479335124878
          },
          {
            "id": "PKYIC7HGGKW5CYVSCVDEIMHY",
            "is_deleted": false,
            "item_variation_data": {
              "item_id": "AA27W3M2GGTF3H6AVPNB77CK",
              "name": "Large",
              "ordinal": 1,
              "price_money": {
                "amount": 350,
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
    }
  ],
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

