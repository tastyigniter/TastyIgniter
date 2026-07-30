
# List Location Custom Attribute Definitions Request

Represents a [ListLocationCustomAttributeDefinitions](../../doc/apis/location-custom-attributes.md#list-location-custom-attribute-definitions) request.

## Structure

`ListLocationCustomAttributeDefinitionsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `visibilityFilter` | [`?string (VisibilityFilter)`](../../doc/models/visibility-filter.md) | Optional | Enumeration of visibility-filter values used to set the ability to view custom attributes or custom attribute definitions. | getVisibilityFilter(): ?string | setVisibilityFilter(?string visibilityFilter): void |
| `limit` | `?int` | Optional | The maximum number of results to return in a single paged response. This limit is advisory.<br>The response might contain more or fewer results. The minimum value is 1 and the maximum value is 100.<br>The default value is 20. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination).<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | The cursor returned in the paged response from the previous call to this endpoint.<br>Provide this cursor to retrieve the next page of results for your original request.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "visibility_filter": "ALL",
  "limit": 172,
  "cursor": "cursor6"
}
```

