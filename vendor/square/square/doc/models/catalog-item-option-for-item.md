
# Catalog Item Option for Item

An option that can be assigned to an item.
For example, a t-shirt item may offer a color option or a size option.

## Structure

`CatalogItemOptionForItem`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemOptionId` | `?string` | Optional | The unique id of the item option, used to form the dimensions of the item option matrix in a specified order. | getItemOptionId(): ?string | setItemOptionId(?string itemOptionId): void |

## Example (as JSON)

```json
{
  "item_option_id": "item_option_id2"
}
```

