
# Catalog Custom Attribute Definition Selection Config Custom Attribute Selection

A named selection for this `SELECTION`-type custom attribute definition.

## Structure

`CatalogCustomAttributeDefinitionSelectionConfigCustomAttributeSelection`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | Unique ID set by Square. | getUid(): ?string | setUid(?string uid): void |
| `name` | `string` | Required | Selection name, unique within `allowed_selections`.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getName(): string | setName(string name): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "name": "name0"
}
```

