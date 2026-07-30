
# Bulk Upsert Location Custom Attributes Request

Represents a [BulkUpsertLocationCustomAttributes](../../doc/apis/location-custom-attributes.md#bulk-upsert-location-custom-attributes) request.

## Structure

`BulkUpsertLocationCustomAttributesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `values` | [`array<string,BulkUpsertLocationCustomAttributesRequestLocationCustomAttributeUpsertRequest>`](../../doc/models/bulk-upsert-location-custom-attributes-request-location-custom-attribute-upsert-request.md) | Required | A map containing 1 to 25 individual upsert requests. For each request, provide an<br>arbitrary ID that is unique for this `BulkUpsertLocationCustomAttributes` request and the<br>information needed to create or update a custom attribute. | getValues(): array | setValues(array values): void |

## Example (as JSON)

```json
{
  "values": {
    "key0": {
      "location_id": "location_id4",
      "custom_attribute": {
        "key": "key8",
        "value": {
          "key1": "val1",
          "key2": "val2"
        },
        "version": 82,
        "visibility": "VISIBILITY_READ_WRITE_VALUES",
        "definition": {
          "key": "key8",
          "schema": {
            "key1": "val1",
            "key2": "val2"
          },
          "name": "name8",
          "description": "description8",
          "visibility": "VISIBILITY_HIDDEN",
          "version": 178,
          "updated_at": "updated_at4",
          "created_at": "created_at6"
        },
        "updated_at": "updated_at6",
        "created_at": "created_at4"
      },
      "idempotency_key": "idempotency_key6"
    },
    "key1": {
      "location_id": "location_id5",
      "custom_attribute": {
        "key": "key9",
        "value": {
          "key1": "val1",
          "key2": "val2"
        },
        "version": 83,
        "visibility": "VISIBILITY_READ_ONLY",
        "definition": {
          "key": "key9",
          "schema": {
            "key1": "val1",
            "key2": "val2"
          },
          "name": "name9",
          "description": "description9",
          "visibility": "VISIBILITY_READ_ONLY",
          "version": 179,
          "updated_at": "updated_at5",
          "created_at": "created_at7"
        },
        "updated_at": "updated_at5",
        "created_at": "created_at3"
      },
      "idempotency_key": "idempotency_key7"
    },
    "key2": {
      "location_id": "location_id6",
      "custom_attribute": {
        "key": "key0",
        "value": {
          "key1": "val1",
          "key2": "val2"
        },
        "version": 84,
        "visibility": "VISIBILITY_HIDDEN",
        "definition": {
          "key": "key0",
          "schema": {
            "key1": "val1",
            "key2": "val2"
          },
          "name": "name0",
          "description": "description0",
          "visibility": "VISIBILITY_READ_WRITE_VALUES",
          "version": 180,
          "updated_at": "updated_at6",
          "created_at": "created_at8"
        },
        "updated_at": "updated_at4",
        "created_at": "created_at2"
      },
      "idempotency_key": "idempotency_key8"
    }
  }
}
```

