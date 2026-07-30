
# Search Orders State Filter

Filter by the current order `state`.

## Structure

`SearchOrdersStateFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `states` | [`string[] (OrderState)`](../../doc/models/order-state.md) | Required | States to filter for.<br>See [OrderState](#type-orderstate) for possible values | getStates(): array | setStates(array states): void |

## Example (as JSON)

```json
{
  "states": [
    "OPEN",
    "COMPLETED"
  ]
}
```

