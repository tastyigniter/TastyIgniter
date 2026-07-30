
# Invoice Sort

Identifies the sort field and sort order.

## Structure

`InvoiceSort`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `field` | `string` | Required, Constant | The field to use for sorting.<br>**Default**: `'INVOICE_SORT_DATE'` | getField(): string | setField(string field): void |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |

## Example (as JSON)

```json
{
  "field": "INVOICE_SORT_DATE"
}
```

