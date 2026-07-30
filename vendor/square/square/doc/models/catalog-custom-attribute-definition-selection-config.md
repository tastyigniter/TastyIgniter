
# Catalog Custom Attribute Definition Selection Config

Configuration associated with `SELECTION`-type custom attribute definitions.

## Structure

`CatalogCustomAttributeDefinitionSelectionConfig`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `maxAllowedSelections` | `?int` | Optional | The maximum number of selections that can be set. The maximum value for this<br>attribute is 100. The default value is 1. The value can be modified, but changing the value will not<br>affect existing custom attribute values on objects. Clients need to<br>handle custom attributes with more selected values than allowed by this limit.<br>**Constraints**: `<= 100` | getMaxAllowedSelections(): ?int | setMaxAllowedSelections(?int maxAllowedSelections): void |
| `allowedSelections` | [`?(CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection[])`](../../doc/models/catalog-custom-attribute-definition-selection-config-custom-attribute-selection.md) | Optional | The set of valid `CatalogCustomAttributeSelections`. Up to a maximum of 100<br>selections can be defined. Can be modified. | getAllowedSelections(): ?array | setAllowedSelections(?array allowedSelections): void |

## Example (as JSON)

```json
{
  "max_allowed_selections": 86,
  "allowed_selections": [
    {
      "uid": "uid5",
      "name": "name5"
    },
    {
      "uid": "uid6",
      "name": "name6"
    },
    {
      "uid": "uid7",
      "name": "name7"
    }
  ]
}
```

