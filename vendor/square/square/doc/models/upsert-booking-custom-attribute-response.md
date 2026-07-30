
# Upsert Booking Custom Attribute Response

Represents an [UpsertBookingCustomAttribute](../../doc/apis/booking-custom-attributes.md#upsert-booking-custom-attribute) response.
Either `custom_attribute_definition` or `errors` is present in the response.

## Structure

`UpsertBookingCustomAttributeResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customAttribute` | [`?CustomAttribute`](../../doc/models/custom-attribute.md) | Optional | A custom attribute value. Each custom attribute value has a corresponding<br>`CustomAttributeDefinition` object. | getCustomAttribute(): ?CustomAttribute | setCustomAttribute(?CustomAttribute customAttribute): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

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
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ]
}
```

