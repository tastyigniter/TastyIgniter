
# Catalog Item Option Value for Item Variation

A `CatalogItemOptionValue` links an item variation to an item option as
an item option value. For example, a t-shirt item may offer a color option and
a size option. An item option value would represent each variation of t-shirt:
For example, "Color:Red, Size:Small" or "Color:Blue, Size:Medium".

## Structure

`CatalogItemOptionValueForItemVariation`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemOptionId` | `?string` | Optional | The unique id of an item option. | getItemOptionId(): ?string | setItemOptionId(?string itemOptionId): void |
| `itemOptionValueId` | `?string` | Optional | The unique id of the selected value for the item option. | getItemOptionValueId(): ?string | setItemOptionValueId(?string itemOptionValueId): void |

## Example (as JSON)

```json
{
  "item_option_id": "item_option_id2",
  "item_option_value_id": "item_option_value_id0"
}
```

