
# List Customer Segments Request

Defines the valid parameters for requests to the `ListCustomerSegments` endpoint.

## Structure

`ListCustomerSegmentsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by previous calls to `ListCustomerSegments`.<br>This cursor is used to retrieve the next set of query results.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | The maximum number of results to return in a single page. This limit is advisory. The response might contain more or fewer results.<br>If the specified limit is less than 1 or greater than 50, Square returns a `400 VALUE_TOO_LOW` or `400 VALUE_TOO_HIGH` error. The default value is 50.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).<br>**Constraints**: `>= 1`, `<= 50` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{}
```

