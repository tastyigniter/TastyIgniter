
# Catalog Query Range

The query filter to return the search result whose named attribute values fall between the specified range.

## Structure

`CatalogQueryRange`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `attributeName` | `string` | Required | The name of the attribute to be searched.<br>**Constraints**: *Minimum Length*: `1` | getAttributeName(): string | setAttributeName(string attributeName): void |
| `attributeMinValue` | `?int` | Optional | The desired minimum value for the search attribute (inclusive). | getAttributeMinValue(): ?int | setAttributeMinValue(?int attributeMinValue): void |
| `attributeMaxValue` | `?int` | Optional | The desired maximum value for the search attribute (inclusive). | getAttributeMaxValue(): ?int | setAttributeMaxValue(?int attributeMaxValue): void |

## Example (as JSON)

```json
{
  "attribute_name": "attribute_name4",
  "attribute_min_value": 232,
  "attribute_max_value": 114
}
```

