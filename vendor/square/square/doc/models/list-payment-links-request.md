
# List Payment Links Request

## Structure

`ListPaymentLinksRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>If a cursor is not provided, the endpoint returns the first page of the results.<br>For more  information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | A limit on the number of results to return per page. The limit is advisory and<br>the implementation might return more or less results. If the supplied limit is negative, zero, or<br>greater than the maximum limit of 1000, it is ignored.<br><br>Default value: `100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "cursor": "cursor6",
  "limit": 172
}
```

