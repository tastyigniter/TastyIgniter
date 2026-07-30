
# Update Booking Request

## Structure

`UpdateBookingRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique key to make this request an idempotent operation.<br>**Constraints**: *Maximum Length*: `255` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `booking` | [`Booking`](../../doc/models/booking.md) | Required | Represents a booking as a time-bound service contract for a seller's staff member to provide a specified service<br>at a given location to a requesting customer in one or more appointment segments. | getBooking(): Booking | setBooking(Booking booking): void |

## Example (as JSON)

```json
{
  "idempotency_key": "idempotency_key6",
  "booking": {
    "id": "id4",
    "version": 156,
    "status": "CANCELLED_BY_SELLER",
    "created_at": "created_at2",
    "updated_at": "updated_at0",
    "start_at": "start_at6",
    "location_id": "location_id8",
    "customer_id": "customer_id2",
    "customer_note": "customer_note6",
    "seller_note": "seller_note6",
    "appointment_segments": [
      {
        "duration_minutes": 76,
        "service_variation_id": "service_variation_id8",
        "team_member_id": "team_member_id4",
        "service_variation_version": 244,
        "intermission_minutes": 250,
        "any_team_member": false,
        "resource_ids": [
          "resource_ids4",
          "resource_ids5",
          "resource_ids6"
        ]
      },
      {
        "duration_minutes": 77,
        "service_variation_id": "service_variation_id9",
        "team_member_id": "team_member_id5",
        "service_variation_version": 245,
        "intermission_minutes": 251,
        "any_team_member": true,
        "resource_ids": [
          "resource_ids5"
        ]
      }
    ],
    "transition_time_minutes": 64,
    "all_day": false,
    "location_type": "CUSTOMER_LOCATION",
    "creator_details": {
      "creator_type": "TEAM_MEMBER",
      "team_member_id": "team_member_id0",
      "customer_id": "customer_id8"
    },
    "source": "FIRST_PARTY_MERCHANT"
  }
}
```

