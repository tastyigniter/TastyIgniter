
# V1 Order History Entry

V1OrderHistoryEntry

## Structure

`V1OrderHistoryEntry`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `action` | [`?string (V1OrderHistoryEntryAction)`](../../doc/models/v1-order-history-entry-action.md) | Optional | - | getAction(): ?string | setAction(?string action): void |
| `createdAt` | `?string` | Optional | The time when the action was performed, in ISO 8601 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |

## Example (as JSON)

```json
{
  "action": "ORDER_PLACED",
  "created_at": "created_at2"
}
```

