
# Retrieve Inventory Physical Count Response

## Structure

`RetrieveInventoryPhysicalCountResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `count` | [`?InventoryPhysicalCount`](../../doc/models/inventory-physical-count.md) | Optional | Represents the quantity of an item variation that is physically present<br>at a specific location, verified by a seller or a seller's employee. For example,<br>a physical count might come from an employee counting the item variations on<br>hand or from syncing with an external system. | getCount(): ?InventoryPhysicalCount | setCount(?InventoryPhysicalCount count): void |

## Example (as JSON)

```json
{
  "count": {
    "catalog_object_id": "W62UWFY35CWMYGVWK6TWJDNI",
    "catalog_object_type": "ITEM_VARIATION",
    "created_at": "2016-11-16T22:25:24.878Z",
    "id": "ANZADNPLKADOJKJIUANKLMLQ",
    "location_id": "C6W5YS5QM06F5",
    "occurred_at": "2016-11-16T22:25:24.878Z",
    "quantity": "15",
    "reference_id": "f857ec37-f9a0-4458-8e23-5b5e0bea4e53",
    "source": {
      "application_id": "416ff29c-86c4-4feb-b58c-9705f21f3ea0",
      "name": "Square Point of Sale 4.37",
      "product": "SQUARE_POS"
    },
    "state": "IN_STOCK",
    "team_member_id": "LRK57NSQ5X7PUD05"
  },
  "errors": []
}
```

