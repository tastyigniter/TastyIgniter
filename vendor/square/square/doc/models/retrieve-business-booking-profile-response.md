
# Retrieve Business Booking Profile Response

## Structure

`RetrieveBusinessBookingProfileResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `businessBookingProfile` | [`?BusinessBookingProfile`](../../doc/models/business-booking-profile.md) | Optional | - | getBusinessBookingProfile(): ?BusinessBookingProfile | setBusinessBookingProfile(?BusinessBookingProfile businessBookingProfile): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "business_booking_profile": {
    "allow_user_cancel": true,
    "booking_enabled": true,
    "booking_policy": "ACCEPT_ALL",
    "business_appointment_settings": {
      "alignment_time": "HALF_HOURLY",
      "any_team_member_booking_enabled": true,
      "cancellation_fee_money": {
        "currency": "USD"
      },
      "cancellation_policy": "CUSTOM_POLICY",
      "location_types": [
        "BUSINESS_LOCATION"
      ],
      "max_booking_lead_time_seconds": 31536000,
      "min_booking_lead_time_seconds": 0,
      "multiple_service_booking_enabled": true,
      "skip_booking_flow_staff_selection": false
    },
    "created_at": "2020-09-10T21:40:38Z",
    "customer_timezone_choice": "CUSTOMER_CHOICE",
    "seller_id": "MLJQYZZRM0D3Y"
  },
  "errors": []
}
```

