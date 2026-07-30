
# Catalog Custom Attribute Definition Number Config

## Structure

`CatalogCustomAttributeDefinitionNumberConfig`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `precision` | `?int` | Optional | An integer between 0 and 5 that represents the maximum number of<br>positions allowed after the decimal in number custom attribute values<br>For example:<br><br>- if the precision is 0, the quantity can be 1, 2, 3, etc.<br>- if the precision is 1, the quantity can be 0.1, 0.2, etc.<br>- if the precision is 2, the quantity can be 0.01, 0.12, etc.<br><br>Default: 5<br>**Constraints**: `<= 5` | getPrecision(): ?int | setPrecision(?int precision): void |

## Example (as JSON)

```json
{
  "precision": 196
}
```

