
# List Customers Request

Defines the query parameters that can be included in a request to the
`ListCustomers` endpoint.

## Structure

`ListCustomersRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for your original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | The maximum number of results to return in a single page. This limit is advisory. The response might contain more or fewer results.<br>If the specified limit is less than 1 or greater than 100, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 100.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |
| `sortField` | [`?string (CustomerSortField)`](../../doc/models/customer-sort-field.md) | Optional | Specifies customer attributes as the sort key to customer profiles returned from a search. | getSortField(): ?string | setSortField(?string sortField): void |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |

## Example (as JSON)

```json
{
  "cursor": "cursor6",
  "limit": 172,
  "sort_field": "DEFAULT",
  "sort_order": "DESC"
}
```

