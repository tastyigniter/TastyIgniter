
# Delete Booking Custom Attribute Response

Represents a [DeleteBookingCustomAttribute](../../doc/apis/booking-custom-attributes.md#delete-booking-custom-attribute) response.
Either an empty object `{}` (for a successful deletion) or `errors` is present in the response.

## Structure

`DeleteBookingCustomAttributeResponse`

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

