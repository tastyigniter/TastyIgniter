
# Bulk Delete Location Custom Attributes Response

Represents a [BulkDeleteLocationCustomAttributes](../../doc/apis/location-custom-attributes.md#bulk-delete-location-custom-attributes) response,
which contains a map of responses that each corresponds to an individual delete request.

## Structure

`BulkDeleteLocationCustomAttributesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `values` | [`array<string,BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse>`](../../doc/models/bulk-delete-location-custom-attributes-response-location-custom-attribute-delete-response.md) | Required | A map of responses that correspond to individual delete requests. Each response has the<br>same key as the corresponding request. | getValues(): array | setValues(array values): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "values": {
    "id1": {
      "errors": [],
      "location_id": "L0TBCBTB7P8RQ"
    },
    "id2": {
      "errors": [],
      "location_id": "L9XMD04V3STJX"
    },
    "id3": {
      "errors": [],
      "location_id": "L0TBCBTB7P8RQ"
    }
  }
}
```

