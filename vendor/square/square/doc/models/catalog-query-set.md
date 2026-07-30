
# Catalog Query Set

The query filter to return the search result(s) by exact match of the specified `attribute_name` and any of
the `attribute_values`.

## Structure

`CatalogQuerySet`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `attributeName` | `string` | Required | The name of the attribute to be searched. Matching of the attribute name is exact.<br>**Constraints**: *Minimum Length*: `1` | getAttributeName(): string | setAttributeName(string attributeName): void |
| `attributeValues` | `string[]` | Required | The desired values of the search attribute. Matching of the attribute values is exact and case insensitive.<br>A maximum of 250 values may be searched in a request. | getAttributeValues(): array | setAttributeValues(array attributeValues): void |

## Example (as JSON)

```json
{
  "attribute_name": "attribute_name4",
  "attribute_values": [
    "attribute_values2",
    "attribute_values3",
    "attribute_values4"
  ]
}
```

