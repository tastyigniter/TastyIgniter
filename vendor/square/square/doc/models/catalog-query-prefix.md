
# Catalog Query Prefix

The query filter to return the search result whose named attribute values are prefixed by the specified attribute value.

## Structure

`CatalogQueryPrefix`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `attributeName` | `string` | Required | The name of the attribute to be searched.<br>**Constraints**: *Minimum Length*: `1` | getAttributeName(): string | setAttributeName(string attributeName): void |
| `attributePrefix` | `string` | Required | The desired prefix of the search attribute value.<br>**Constraints**: *Minimum Length*: `1` | getAttributePrefix(): string | setAttributePrefix(string attributePrefix): void |

## Example (as JSON)

```json
{
  "attribute_name": "attribute_name4",
  "attribute_prefix": "attribute_prefix0"
}
```

