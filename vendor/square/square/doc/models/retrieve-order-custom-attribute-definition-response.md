
# Retrieve Order Custom Attribute Definition Response

Represents a response from getting an order custom attribute definition.

## Structure

`RetrieveOrderCustomAttributeDefinitionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttributeDefinition` | [`?CustomAttributeDefinition`](../../doc/models/custom-attribute-definition.md) | Optional | Represents a definition for custom attribute values. A custom attribute definition<br>specifies the key, visibility, schema, and other properties for a custom attribute. | getCustomAttributeDefinition(): ?CustomAttributeDefinition | setCustomAttributeDefinition(?CustomAttributeDefinition customAttributeDefinition): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "custom_attribute_definition": {
    "created_at": "2022-10-06T16:53:23.141Z",
    "description": "The number of people seated at a table",
    "key": "cover-count",
    "name": "Cover count",
    "schema": null,
    "updated_at": "2022-10-06T16:53:23.141Z",
    "version": 1,
    "visibility": "VISIBILITY_READ_WRITE_VALUES"
  }
}
```

