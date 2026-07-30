
# Delete Booking Custom Attribute Definition Response

Represents a [DeleteBookingCustomAttributeDefinition](../../doc/apis/booking-custom-attributes.md#delete-booking-custom-attribute-definition) response
containing error messages when errors occurred during the request. The successful response does not contain any payload.

## Structure

`DeleteBookingCustomAttributeDefinitionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "errors": []
}
```

