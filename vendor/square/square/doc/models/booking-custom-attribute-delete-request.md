
# Booking Custom Attribute Delete Request

Represents an individual delete request in a [BulkDeleteBookingCustomAttributes](../../doc/apis/booking-custom-attributes.md#bulk-delete-booking-custom-attributes)
request. An individual request contains a booking ID, the custom attribute to delete, and an optional idempotency key.

## Structure

`BookingCustomAttributeDeleteRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `bookingId` | `string` | Required | The ID of the target [booking](entity:Booking).<br>**Constraints**: *Minimum Length*: `1` | getBookingId(): string | setBookingId(string bookingId): void |
| `key` | `string` | Required | The key of the custom attribute to delete. This key must match the `key` of a<br>custom attribute definition in the Square seller account. If the requesting application is not<br>the definition owner, you must use the qualified key.<br>**Constraints**: *Minimum Length*: `1` | getKey(): string | setKey(string key): void |

## Example (as JSON)

```json
{
  "booking_id": "booking_id4",
  "key": "key0"
}
```

