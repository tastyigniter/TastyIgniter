
# Search Vendors Request

Represents an input into a call to [SearchVendors](../../doc/apis/vendors.md#search-vendors).

## Structure

`SearchVendorsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`?SearchVendorsRequestFilter`](../../doc/models/search-vendors-request-filter.md) | Optional | Defines supported query expressions to search for vendors by. | getFilter(): ?SearchVendorsRequestFilter | setFilter(?SearchVendorsRequestFilter filter): void |
| `sort` | [`?SearchVendorsRequestSort`](../../doc/models/search-vendors-request-sort.md) | Optional | Defines a sorter used to sort results from [SearchVendors](../../doc/apis/vendors.md#search-vendors). | getSort(): ?SearchVendorsRequestSort | setSort(?SearchVendorsRequestSort sort): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for the original query.<br><br>See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for more information. | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | Limit on how many vendors will be returned by the search.<br>**Constraints**: `>= 1`, `<= 500` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "query": {
    "filter": {
      "name": [
        "Joe's Fresh Seafood",
        "Hannah's Bakery"
      ],
      "status": [
        "ACTIVE"
      ]
    },
    "sort": {
      "field": "CREATED_AT",
      "order": "ASC"
    }
  }
}
```

