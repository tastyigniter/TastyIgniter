
# Catalog Query Items for Modifier List

The query filter to return the items containing the specified modifier list IDs.

## Structure

`CatalogQueryItemsForModifierList`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `modifierListIds` | `string[]` | Required | A set of `CatalogModifierList` IDs to be used to find associated `CatalogItem`s. | getModifierListIds(): array | setModifierListIds(array modifierListIds): void |

## Example (as JSON)

```json
{
  "modifier_list_ids": [
    "modifier_list_ids0"
  ]
}
```

