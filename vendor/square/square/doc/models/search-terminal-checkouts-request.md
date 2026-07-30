
# Search Terminal Checkouts Request

## Structure

`SearchTerminalCheckoutsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`?TerminalCheckoutQuery`](../../doc/models/terminal-checkout-query.md) | Optional | - | getQuery(): ?TerminalCheckoutQuery | setQuery(?TerminalCheckoutQuery query): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | Limits the number of results returned for a single request.<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "limit": 2,
  "query": {
    "filter": {
      "status": "COMPLETED"
    }
  }
}
```

