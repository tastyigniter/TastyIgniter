
# Update Item Modifier Lists Request

## Structure

`UpdateItemModifierListsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemIds` | `string[]` | Required | The IDs of the catalog items associated with the CatalogModifierList objects being updated. | getItemIds(): array | setItemIds(array itemIds): void |
| `modifierListsToEnable` | `?(string[])` | Optional | The IDs of the CatalogModifierList objects to enable for the CatalogItem.<br>At least one of `modifier_lists_to_enable` or `modifier_lists_to_disable` must be specified. | getModifierListsToEnable(): ?array | setModifierListsToEnable(?array modifierListsToEnable): void |
| `modifierListsToDisable` | `?(string[])` | Optional | The IDs of the CatalogModifierList objects to disable for the CatalogItem.<br>At least one of `modifier_lists_to_enable` or `modifier_lists_to_disable` must be specified. | getModifierListsToDisable(): ?array | setModifierListsToDisable(?array modifierListsToDisable): void |

## Example (as JSON)

```json
{
  "item_ids": [
    "H42BRLUJ5KTZTTMPVSLFAACQ",
    "2JXOBJIHCWBQ4NZ3RIXQGJA6"
  ],
  "modifier_lists_to_disable": [
    "7WRC16CJZDVLSNDQ35PP6YAD"
  ],
  "modifier_lists_to_enable": [
    "H42BRLUJ5KTZTTMPVSLFAACQ",
    "2JXOBJIHCWBQ4NZ3RIXQGJA6"
  ]
}
```

