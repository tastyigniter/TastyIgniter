
# Retrieve Inventory Changes Response

## Structure

`RetrieveInventoryChangesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `changes` | [`?(InventoryChange[])`](../../doc/models/inventory-change.md) | Optional | The set of inventory changes for the requested object and locations. | getChanges(): ?array | setChanges(?array changes): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If unset,<br>this is the final response.<br><br>See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "changes": [
    {
      "adjustment": {
        "catalog_object_id": "W62UWFY35CWMYGVWK6TWJDNI",
        "catalog_object_type": "ITEM_VARIATION",
        "created_at": "2016-11-16T22:25:24.878Z",
        "from_state": "IN_STOCK",
        "id": "OJKJIUANKLMLQANZADNPLKAD",
        "location_id": "C6W5YS5QM06F5",
        "occurred_at": "2016-11-16T22:25:24.878Z",
        "quantity": "3",
        "reference_id": "d8207693-168f-4b44-a2fd-a7ff533ddd26",
        "source": {
          "application_id": "416ff29c-86c4-4feb-b58c-9705f21f3ea0",
          "name": "Square Point of Sale 4.37",
          "product": "SQUARE_POS"
        },
        "team_member_id": "AV7YRCGI2H1J5NQ8E1XIZCNA",
        "to_state": "SOLD",
        "total_price_money": {
          "amount": 5000,
          "currency": "USD"
        },
        "transaction_id": "5APV6JYK1SNCZD11AND2RX1Z"
      },
      "type": "ADJUSTMENT"
    }
  ],
  "errors": []
}
```

