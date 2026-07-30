
# Batch Change Inventory Response

## Structure

`BatchChangeInventoryResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `counts` | [`?(InventoryCount[])`](../../doc/models/inventory-count.md) | Optional | The current counts for all objects referenced in the request. | getCounts(): ?array | setCounts(?array counts): void |
| `changes` | [`?(InventoryChange[])`](../../doc/models/inventory-change.md) | Optional | Changes created for the request. | getChanges(): ?array | setChanges(?array changes): void |

## Example (as JSON)

```json
{
  "counts": [
    {
      "calculated_at": "2016-11-16T22:28:01.223Z",
      "catalog_object_id": "W62UWFY35CWMYGVWK6TWJDNI",
      "catalog_object_type": "ITEM_VARIATION",
      "location_id": "C6W5YS5QM06F5",
      "quantity": "53",
      "state": "IN_STOCK"
    }
  ],
  "errors": []
}
```

