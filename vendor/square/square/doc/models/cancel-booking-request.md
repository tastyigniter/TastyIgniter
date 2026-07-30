
# Cancel Booking Request

## Structure

`CancelBookingRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique key to make this request an idempotent operation.<br>**Constraints**: *Maximum Length*: `255` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `bookingVersion` | `?int` | Optional | The revision number for the booking used for optimistic concurrency. | getBookingVersion(): ?int | setBookingVersion(?int bookingVersion): void |

## Example (as JSON)

```json
{
  "idempotency_key": "idempotency_key6",
  "booking_version": 0
}
```

