
# Catalog Object Batch

A batch of catalog objects.

## Structure

`CatalogObjectBatch`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `objects` | [`CatalogObject[]`](../../doc/models/catalog-object.md) | Required | A list of CatalogObjects belonging to this batch. | getObjects(): array | setObjects(array objects): void |

## Example (as JSON)

```json
{
  "objects": {
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
}
```

