
# Search Orders Sort

Sorting criteria for a `SearchOrders` request. Results can only be sorted
by a timestamp field.

## Structure

`SearchOrdersSort`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `sortField` | [`string (SearchOrdersSortField)`](../../doc/models/search-orders-sort-field.md) | Required | Specifies which timestamp to use to sort `SearchOrder` results. | getSortField(): string | setSortField(string sortField): void |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |

## Example (as JSON)

```json
{
  "sort_field": "CLOSED_AT",
  "sort_order": "DESC"
}
```

