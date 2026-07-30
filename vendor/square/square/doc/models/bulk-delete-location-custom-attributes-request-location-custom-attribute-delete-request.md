
# Bulk Delete Location Custom Attributes Request Location Custom Attribute Delete Request

Represents an individual delete request in a [BulkDeleteLocationCustomAttributes](../../doc/apis/location-custom-attributes.md#bulk-delete-location-custom-attributes)
request. An individual request contains an optional ID of the associated custom attribute definition
and optional key of the associated custom attribute definition.

## Structure

`BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `key` | `?string` | Optional | The key of the associated custom attribute definition.<br>Represented as a qualified key if the requesting app is not the definition owner.<br>**Constraints**: *Pattern*: `^([a-zA-Z0-9_-]+:)?[a-zA-Z0-9_-]{1,60}$` | getKey(): ?string | setKey(?string key): void |

## Example (as JSON)

```json
{
  "key": "key0"
}
```

