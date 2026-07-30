
# Bulk Upsert Order Custom Attributes Request Upsert Custom Attribute

Represents one upsert within the bulk operation.

## Structure

`BulkUpsertOrderCustomAttributesRequestUpsertCustomAttribute`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttribute` | [`CustomAttribute`](../../doc/models/custom-attribute.md) | Required | A custom attribute value. Each custom attribute value has a corresponding<br>`CustomAttributeDefinition` object. | getCustomAttribute(): CustomAttribute | setCustomAttribute(CustomAttribute customAttribute): void |
| `idempotencyKey` | `?string` | Optional | A unique identifier for this request, used to ensure idempotency.<br>For more information, see [Idempotency](https://developer.squareup.com/docs/basics/api101/idempotency).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `45` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `orderId` | `string` | Required | The ID of the target [order](entity:Order).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getOrderId(): string | setOrderId(string orderId): void |

## Example (as JSON)

```json
{
  "custom_attribute": {
    "key": "key2",
    "value": {
      "key1": "val1",
      "key2": "val2"
    },
    "version": 102,
    "visibility": "VISIBILITY_READ_ONLY",
    "definition": {
      "key": "key2",
      "schema": {
        "key1": "val1",
        "key2": "val2"
      },
      "name": "name2",
      "description": "description2",
      "visibility": "VISIBILITY_READ_ONLY",
      "version": 198,
      "updated_at": "updated_at8",
      "created_at": "created_at0"
    },
    "updated_at": "updated_at2",
    "created_at": "created_at0"
  },
  "idempotency_key": "idempotency_key6",
  "order_id": "order_id6"
}
```

