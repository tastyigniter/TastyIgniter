
# V1 Payment Item Detail

V1PaymentItemDetail

## Structure

`V1PaymentItemDetail`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `categoryName` | `?string` | Optional | The name of the item's merchant-defined category, if any. | getCategoryName(): ?string | setCategoryName(?string categoryName): void |
| `sku` | `?string` | Optional | The item's merchant-defined SKU, if any. | getSku(): ?string | setSku(?string sku): void |
| `itemId` | `?string` | Optional | The unique ID of the item purchased, if any. | getItemId(): ?string | setItemId(?string itemId): void |
| `itemVariationId` | `?string` | Optional | The unique ID of the item variation purchased, if any. | getItemVariationId(): ?string | setItemVariationId(?string itemVariationId): void |

## Example (as JSON)

```json
{
  "category_name": "category_name8",
  "sku": "sku4",
  "item_id": "item_id0",
  "item_variation_id": "item_variation_id4"
}
```

