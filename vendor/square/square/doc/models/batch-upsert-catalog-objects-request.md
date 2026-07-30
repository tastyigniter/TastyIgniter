
# Batch Upsert Catalog Objects Request

## Structure

`BatchUpsertCatalogObjectsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A value you specify that uniquely identifies this<br>request among all your requests. A common way to create<br>a valid idempotency key is to use a Universally unique<br>identifier (UUID).<br><br>If you're unsure whether a particular request was successful,<br>you can reattempt it with the same idempotency key without<br>worrying about creating duplicate objects.<br><br>See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency) for more information.<br>**Constraints**: *Minimum Length*: `1` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `batches` | [`CatalogObjectBatch[]`](../../doc/models/catalog-object-batch.md) | Required | A batch of CatalogObjects to be inserted/updated atomically.<br>The objects within a batch will be inserted in an all-or-nothing fashion, i.e., if an error occurs<br>attempting to insert or update an object within a batch, the entire batch will be rejected. However, an error<br>in one batch will not affect other batches within the same request.<br><br>For each object, its `updated_at` field is ignored and replaced with a current [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates), and its<br>`is_deleted` field must not be set to `true`.<br><br>To modify an existing object, supply its ID. To create a new object, use an ID starting<br>with `#`. These IDs may be used to create relationships between an object and attributes of<br>other objects that reference it. For example, you can create a CatalogItem with<br>ID `#ABC` and a CatalogItemVariation with its `item_id` attribute set to<br>`#ABC` in order to associate the CatalogItemVariation with its parent<br>CatalogItem.<br><br>Any `#`-prefixed IDs are valid only within a single atomic batch, and will be replaced by server-generated IDs.<br><br>Each batch may contain up to 1,000 objects. The total number of objects across all batches for a single request<br>may not exceed 10,000. If either of these limits is violated, an error will be returned and no objects will<br>be inserted or updated. | getBatches(): array | setBatches(array batches): void |

## Example (as JSON)

```json
{
  "batches": [
    {
      "objects": [
        {
          "id": "#Tea",
          "item_data": {
            "category_id": "#Beverages",
            "description_html": "<p><strong>Hot</strong> Leaf Juice</p>",
            "name": "Tea",
            "tax_ids": [
              "#SalesTax"
            ],
            "variations": [
              {
                "id": "#Tea_Mug",
                "item_variation_data": {
                  "item_id": "#Tea",
                  "name": "Mug",
                  "price_money": {
                    "amount": 150,
                    "currency": "USD"
                  },
                  "pricing_type": "FIXED_PRICING"
                },
                "present_at_all_locations": true,
                "type": "ITEM_VARIATION"
              }
            ]
          },
          "present_at_all_locations": true,
          "type": "ITEM"
        },
        {
          "id": "#Coffee",
          "item_data": {
            "category_id": "#Beverages",
            "description_html": "<p>Hot <em>Bean Juice</em></p>",
            "name": "Coffee",
            "tax_ids": [
              "#SalesTax"
            ],
            "variations": [
              {
                "id": "#Coffee_Regular",
                "item_variation_data": {
                  "item_id": "#Coffee",
                  "name": "Regular",
                  "price_money": {
                    "amount": 250,
                    "currency": "USD"
                  },
                  "pricing_type": "FIXED_PRICING"
                },
                "present_at_all_locations": true,
                "type": "ITEM_VARIATION"
              },
              {
                "id": "#Coffee_Large",
                "item_variation_data": {
                  "item_id": "#Coffee",
                  "name": "Large",
                  "price_money": {
                    "amount": 350,
                    "currency": "USD"
                  },
                  "pricing_type": "FIXED_PRICING"
                },
                "present_at_all_locations": true,
                "type": "ITEM_VARIATION"
              }
            ]
          },
          "present_at_all_locations": true,
          "type": "ITEM"
        },
        {
          "category_data": {
            "name": "Beverages"
          },
          "id": "#Beverages",
          "present_at_all_locations": true,
          "type": "CATEGORY"
        },
        {
          "id": "#SalesTax",
          "present_at_all_locations": true,
          "tax_data": {
            "applies_to_custom_amounts": true,
            "calculation_phase": "TAX_SUBTOTAL_PHASE",
            "enabled": true,
            "inclusion_type": "ADDITIVE",
            "name": "Sales Tax",
            "percentage": "5.0"
          },
          "type": "TAX"
        }
      ]
    }
  ],
  "idempotency_key": "789ff020-f723-43a9-b4b5-43b5dc1fa3dc"
}
```

