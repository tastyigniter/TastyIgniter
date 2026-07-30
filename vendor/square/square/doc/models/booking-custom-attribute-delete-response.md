
# Booking Custom Attribute Delete Response

Represents a response for an individual upsert request in a [BulkDeleteBookingCustomAttributes](../../doc/apis/booking-custom-attributes.md#bulk-delete-booking-custom-attributes) operation.

## Structure

`BookingCustomAttributeDeleteResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `bookingId` | `?string` | Optional | The ID of the [booking](entity:Booking) associated with the custom attribute. | getBookingId(): ?string | setBookingId(?string bookingId): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred while processing the individual request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "booking_id": "N3NCVYY3WS27HF0HKANA3R9FP8",
  "errors": []
}
```

