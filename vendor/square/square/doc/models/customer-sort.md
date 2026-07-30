
# Customer Sort

Represents the sorting criteria in a [search query](../../doc/models/customer-query.md) that defines how to sort
customer profiles returned in [SearchCustomers](../../doc/apis/customers.md#search-customers) results.

## Structure

`CustomerSort`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `field` | [`?string (CustomerSortField)`](../../doc/models/customer-sort-field.md) | Optional | Specifies customer attributes as the sort key to customer profiles returned from a search. | getField(): ?string | setField(?string field): void |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |

## Example (as JSON)

```json
{
  "field": "DEFAULT",
  "order": "DESC"
}
```

