
# Catalog Custom Attribute Value

An instance of a custom attribute. Custom attributes can be defined and
added to `ITEM` and `ITEM_VARIATION` type catalog objects.
[Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-attributes).

## Structure

`CatalogCustomAttributeValue`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The name of the custom attribute. | getName(): ?string | setName(?string name): void |
| `stringValue` | `?string` | Optional | The string value of the custom attribute.  Populated if `type` = `STRING`. | getStringValue(): ?string | setStringValue(?string stringValue): void |
| `customAttributeDefinitionId` | `?string` | Optional | The id of the [CatalogCustomAttributeDefinition](entity:CatalogCustomAttributeDefinition) this value belongs to. | getCustomAttributeDefinitionId(): ?string | setCustomAttributeDefinitionId(?string customAttributeDefinitionId): void |
| `type` | [`?string (CatalogCustomAttributeDefinitionType)`](../../doc/models/catalog-custom-attribute-definition-type.md) | Optional | Defines the possible types for a custom attribute. | getType(): ?string | setType(?string type): void |
| `numberValue` | `?string` | Optional | Populated if `type` = `NUMBER`. Contains a string<br>representation of a decimal number, using a `.` as the decimal separator. | getNumberValue(): ?string | setNumberValue(?string numberValue): void |
| `booleanValue` | `?bool` | Optional | A `true` or `false` value. Populated if `type` = `BOOLEAN`. | getBooleanValue(): ?bool | setBooleanValue(?bool booleanValue): void |
| `selectionUidValues` | `?(string[])` | Optional | One or more choices from `allowed_selections`. Populated if `type` = `SELECTION`. | getSelectionUidValues(): ?array | setSelectionUidValues(?array selectionUidValues): void |
| `key` | `?string` | Optional | If the associated `CatalogCustomAttributeDefinition` object is defined by another application, this key is prefixed by the defining application ID.<br>For example, if the CatalogCustomAttributeDefinition has a key attribute of "cocoa_brand" and the defining application ID is "abcd1234", this key is "abcd1234:cocoa_brand"<br>when the application making the request is different from the application defining the custom attribute definition. Otherwise, the key is simply "cocoa_brand". | getKey(): ?string | setKey(?string key): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "string_value": "string_value4",
  "custom_attribute_definition_id": "custom_attribute_definition_id2",
  "type": "NUMBER",
  "number_value": "number_value0",
  "boolean_value": false,
  "selection_uid_values": [
    "selection_uid_values7"
  ],
  "key": "key0"
}
```

