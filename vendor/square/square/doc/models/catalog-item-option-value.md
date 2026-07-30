
# Catalog Item Option Value

An enumerated value that can link a
`CatalogItemVariation` to an item option as one of
its item option values.

## Structure

`CatalogItemOptionValue`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemOptionId` | `?string` | Optional | Unique ID of the associated item option. | getItemOptionId(): ?string | setItemOptionId(?string itemOptionId): void |
| `name` | `?string` | Optional | Name of this item option value. This is a searchable attribute for use in applicable query filters. | getName(): ?string | setName(?string name): void |
| `description` | `?string` | Optional | A human-readable description for the option value. This is a searchable attribute for use in applicable query filters. | getDescription(): ?string | setDescription(?string description): void |
| `color` | `?string` | Optional | The HTML-supported hex color for the item option (e.g., "#ff8d4e85").<br>Only displayed if `show_colors` is enabled on the parent `ItemOption`. When<br>left unset, `color` defaults to white ("#ffffff") when `show_colors` is<br>enabled on the parent `ItemOption`. | getColor(): ?string | setColor(?string color): void |
| `ordinal` | `?int` | Optional | Determines where this option value appears in a list of option values. | getOrdinal(): ?int | setOrdinal(?int ordinal): void |

## Example (as JSON)

```json
{
  "item_option_id": "item_option_id2",
  "name": "name0",
  "description": "description0",
  "color": "color6",
  "ordinal": 80
}
```

