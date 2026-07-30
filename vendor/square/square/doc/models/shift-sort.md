
# Shift Sort

Sets the sort order of search results.

## Structure

`ShiftSort`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `field` | [`?string (ShiftSortField)`](../../doc/models/shift-sort-field.md) | Optional | Enumerates the `Shift` fields to sort on. | getField(): ?string | setField(?string field): void |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |

## Example (as JSON)

```json
{
  "field": "START_AT",
  "order": "DESC"
}
```

