
# Bulk Delete Location Custom Attributes Response Location Custom Attribute Delete Response

Represents an individual delete response in a [BulkDeleteLocationCustomAttributes](../../doc/apis/location-custom-attributes.md#bulk-delete-location-custom-attributes)
request.

## Structure

`BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationId` | `?string` | Optional | The ID of the location associated with the custom attribute. | getLocationId(): ?string | setLocationId(?string locationId): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred while processing the individual LocationCustomAttributeDeleteRequest request | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "errors": [],
  "location_id": "L0TBCBTB7P8RQ"
}
```

