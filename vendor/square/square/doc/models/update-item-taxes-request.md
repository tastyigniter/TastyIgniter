
# Update Item Taxes Request

## Structure

`UpdateItemTaxesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemIds` | `string[]` | Required | IDs for the CatalogItems associated with the CatalogTax objects being updated.<br>No more than 1,000 IDs may be provided. | getItemIds(): array | setItemIds(array itemIds): void |
| `taxesToEnable` | `?(string[])` | Optional | IDs of the CatalogTax objects to enable.<br>At least one of `taxes_to_enable` or `taxes_to_disable` must be specified. | getTaxesToEnable(): ?array | setTaxesToEnable(?array taxesToEnable): void |
| `taxesToDisable` | `?(string[])` | Optional | IDs of the CatalogTax objects to disable.<br>At least one of `taxes_to_enable` or `taxes_to_disable` must be specified. | getTaxesToDisable(): ?array | setTaxesToDisable(?array taxesToDisable): void |

## Example (as JSON)

```json
{
  "item_ids": [
    "H42BRLUJ5KTZTTMPVSLFAACQ",
    "2JXOBJIHCWBQ4NZ3RIXQGJA6"
  ],
  "taxes_to_disable": [
    "AQCEGCEBBQONINDOHRGZISEX"
  ],
  "taxes_to_enable": [
    "4WRCNHCJZDVLSNDQ35PP6YAD"
  ]
}
```

