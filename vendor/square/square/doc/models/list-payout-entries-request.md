
# List Payout Entries Request

## Structure

`ListPayoutEntriesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).<br>If request parameters change between requests, subsequent results may contain duplicates or missing records. | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | The maximum number of results to be returned in a single page.<br>It is possible to receive fewer results than the specified limit on a given page.<br>The default value of 100 is also the maximum allowed value. If the provided value is<br>greater than 100, it is ignored and the default value is used instead.<br>Default: `100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{}
```

