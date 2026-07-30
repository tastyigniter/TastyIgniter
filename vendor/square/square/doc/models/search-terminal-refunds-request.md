
# Search Terminal Refunds Request

## Structure

`SearchTerminalRefundsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`?TerminalRefundQuery`](../../doc/models/terminal-refund-query.md) | Optional | - | getQuery(): ?TerminalRefundQuery | setQuery(?TerminalRefundQuery query): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query. | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | Limits the number of results returned for a single request.<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "limit": 1,
  "query": {
    "filter": {
      "status": "COMPLETED"
    }
  }
}
```

