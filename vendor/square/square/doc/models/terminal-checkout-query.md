
# Terminal Checkout Query

## Structure

`TerminalCheckoutQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?TerminalCheckoutQueryFilter`](../../doc/models/terminal-checkout-query-filter.md) | Optional | - | getFilter(): ?TerminalCheckoutQueryFilter | setFilter(?TerminalCheckoutQueryFilter filter): void |
| `sort` | [`?TerminalCheckoutQuerySort`](../../doc/models/terminal-checkout-query-sort.md) | Optional | - | getSort(): ?TerminalCheckoutQuerySort | setSort(?TerminalCheckoutQuerySort sort): void |

## Example (as JSON)

```json
{
  "filter": {
    "device_id": "device_id0",
    "created_at": {
      "start_at": "start_at4",
      "end_at": "end_at8"
    },
    "status": "status6"
  },
  "sort": {
    "sort_order": "DESC"
  }
}
```

