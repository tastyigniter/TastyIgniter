
# Bulk Upsert Order Custom Attributes Request

Represents a bulk upsert request for one or more order custom attributes.

## Structure

`BulkUpsertOrderCustomAttributesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `values` | [`array<string,BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute>`](../../doc/models/bulk-upsert-order-custom-attributes-request-upsert-custom-attribute.md) | Required | A map of requests that correspond to individual upsert operations for custom attributes. | getValues(): array | setValues(array values): void |

## Example (as JSON)

```json
{
  "values": {
    "key0": {
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
      "idempotency_key": "idempotency_key6",
      "order_id": "order_id4"
    },
    "key1": {
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
      "idempotency_key": "idempotency_key7",
      "order_id": "order_id5"
    },
    "key2": {
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
      "idempotency_key": "idempotency_key8",
      "order_id": "order_id6"
    }
  }
}
```

