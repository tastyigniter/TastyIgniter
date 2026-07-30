
# Invoice Query

Describes query criteria for searching invoices.

## Structure

`InvoiceQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`InvoiceFilter`](../../doc/models/invoice-filter.md) | Required | Describes query filters to apply. | getFilter(): InvoiceFilter | setFilter(InvoiceFilter filter): void |
| `sort` | [`?InvoiceSort`](../../doc/models/invoice-sort.md) | Optional | Identifies the sort field and sort order. | getSort(): ?InvoiceSort | setSort(?InvoiceSort sort): void |

## Example (as JSON)

```json
{
  "filter": {
    "location_ids": [
      "location_ids4"
    ],
    "customer_ids": [
      "customer_ids3",
      "customer_ids2"
    ]
  },
  "sort": {
    "field": "field2",
    "order": "DESC"
  }
}
```

