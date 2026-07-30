
# List Bookings Response

## Structure

`ListBookingsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `bookings` | [`?(Booking[])`](../../doc/models/booking.md) | Optional | The list of targeted bookings. | getBookings(): ?array | setBookings(?array bookings): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in the subsequent request to get the next page of the results. Stop retrieving the next page of the results when the cursor is not set.<br>**Constraints**: *Maximum Length*: `65536` | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "bookings": [
    {
      "id": "id1",
      "version": 157,
      "status": "CANCELLED_BY_CUSTOMER",
      "created_at": "created_at9",
      "updated_at": "updated_at7",
      "start_at": "start_at3",
      "location_id": "location_id5",
      "customer_id": "customer_id9",
      "customer_note": "customer_note3",
      "seller_note": "seller_note3",
      "appointment_segments": [
        {
          "duration_minutes": 77,
          "service_variation_id": "service_variation_id5",
          "team_member_id": "team_member_id1",
          "service_variation_version": 245,
          "intermission_minutes": 251,
          "any_team_member": true,
          "resource_ids": [
            "resource_ids1",
            "resource_ids2"
          ]
        }
      ],
      "transition_time_minutes": 65,
      "all_day": true,
      "location_type": "BUSINESS_LOCATION",
      "creator_details": {
        "creator_type": "CUSTOMER",
        "team_member_id": "team_member_id3",
        "customer_id": "customer_id5"
      },
      "source": "FIRST_PARTY_BUYER"
    }
  ],
  "cursor": "cursor6",
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

