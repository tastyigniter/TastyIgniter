
# Terminal Refund Query

## Structure

`TerminalRefundQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?TerminalRefundQueryFilter`](../../doc/models/terminal-refund-query-filter.md) | Optional | - | getFilter(): ?TerminalRefundQueryFilter | setFilter(?TerminalRefundQueryFilter filter): void |
| `sort` | [`?TerminalRefundQuerySort`](../../doc/models/terminal-refund-query-sort.md) | Optional | - | getSort(): ?TerminalRefundQuerySort | setSort(?TerminalRefundQuerySort sort): void |

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
    "sort_order": "sort_order8"
  }
}
```

