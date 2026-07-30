
# Search Vendors Request Sort

Defines a sorter used to sort results from [SearchVendors](../../doc/apis/vendors.md#search-vendors).

## Structure

`SearchVendorsRequestSort`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `field` | [`?string (SearchVendorsRequestSortField)`](../../doc/models/search-vendors-request-sort-field.md) | Optional | The field to sort the returned [Vendor](../../doc/models/vendor.md) objects by. | getField(): ?string | setField(?string field): void |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |

## Example (as JSON)

```json
{
  "field": "NAME",
  "order": "DESC"
}
```

