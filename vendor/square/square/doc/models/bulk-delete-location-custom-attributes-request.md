
# Bulk Delete Location Custom Attributes Request

Represents a [BulkDeleteLocationCustomAttributes](../../doc/apis/location-custom-attributes.md#bulk-delete-location-custom-attributes) request.

## Structure

`BulkDeleteLocationCustomAttributesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `values` | [`array<string,BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest>`](../../doc/models/bulk-delete-location-custom-attributes-request-location-custom-attribute-delete-request.md) | Required | The data used to update the `CustomAttribute` objects.<br>The keys must be unique and are used to map to the corresponding response. | getValues(): array | setValues(array values): void |

## Example (as JSON)

```json
{
  "values": {
    "id1": {
      "key": "bestseller",
      "location_id": "L0TBCBTB7P8RQ"
    },
    "id2": {
      "key": "bestseller",
      "location_id": "L9XMD04V3STJX"
    },
    "id3": {
      "key": "phone-number",
      "location_id": "L0TBCBTB7P8RQ"
    }
  }
}
```

