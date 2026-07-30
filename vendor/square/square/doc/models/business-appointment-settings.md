
# Business Appointment Settings

The service appointment settings, including where and how the service is provided.

## Structure

`BusinessAppointmentSettings`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationTypes` | [`?(string[]) (BusinessAppointmentSettingsBookingLocationType)`](../../doc/models/business-appointment-settings-booking-location-type.md) | Optional | Types of the location allowed for bookings.<br>See [BusinessAppointmentSettingsBookingLocationType](#type-businessappointmentsettingsbookinglocationtype) for possible values | getLocationTypes(): ?array | setLocationTypes(?array locationTypes): void |
| `alignmentTime` | [`?string (BusinessAppointmentSettingsAlignmentTime)`](../../doc/models/business-appointment-settings-alignment-time.md) | Optional | Time units of a service duration for bookings. | getAlignmentTime(): ?string | setAlignmentTime(?string alignmentTime): void |
| `minBookingLeadTimeSeconds` | `?int` | Optional | The minimum lead time in seconds before a service can be booked. Bookings must be created at least this far ahead of the booking's starting time. | getMinBookingLeadTimeSeconds(): ?int | setMinBookingLeadTimeSeconds(?int minBookingLeadTimeSeconds): void |
| `maxBookingLeadTimeSeconds` | `?int` | Optional | The maximum lead time in seconds before a service can be booked. Bookings must be created at most this far ahead of the booking's starting time. | getMaxBookingLeadTimeSeconds(): ?int | setMaxBookingLeadTimeSeconds(?int maxBookingLeadTimeSeconds): void |
| `anyTeamMemberBookingEnabled` | `?bool` | Optional | Indicates whether a customer can choose from all available time slots and have a staff member assigned<br>automatically (`true`) or not (`false`). | getAnyTeamMemberBookingEnabled(): ?bool | setAnyTeamMemberBookingEnabled(?bool anyTeamMemberBookingEnabled): void |
| `multipleServiceBookingEnabled` | `?bool` | Optional | Indicates whether a customer can book multiple services in a single online booking. | getMultipleServiceBookingEnabled(): ?bool | setMultipleServiceBookingEnabled(?bool multipleServiceBookingEnabled): void |
| `maxAppointmentsPerDayLimitType` | [`?string (BusinessAppointmentSettingsMaxAppointmentsPerDayLimitType)`](../../doc/models/business-appointment-settings-max-appointments-per-day-limit-type.md) | Optional | Types of daily appointment limits. | getMaxAppointmentsPerDayLimitType(): ?string | setMaxAppointmentsPerDayLimitType(?string maxAppointmentsPerDayLimitType): void |
| `maxAppointmentsPerDayLimit` | `?int` | Optional | The maximum number of daily appointments per team member or per location. | getMaxAppointmentsPerDayLimit(): ?int | setMaxAppointmentsPerDayLimit(?int maxAppointmentsPerDayLimit): void |
| `cancellationWindowSeconds` | `?int` | Optional | The cut-off time in seconds for allowing clients to cancel or reschedule an appointment. | getCancellationWindowSeconds(): ?int | setCancellationWindowSeconds(?int cancellationWindowSeconds): void |
| `cancellationFeeMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getCancellationFeeMoney(): ?Money | setCancellationFeeMoney(?Money cancellationFeeMoney): void |
| `cancellationPolicy` | [`?string (BusinessAppointmentSettingsCancellationPolicy)`](../../doc/models/business-appointment-settings-cancellation-policy.md) | Optional | The category of the seller’s cancellation policy. | getCancellationPolicy(): ?string | setCancellationPolicy(?string cancellationPolicy): void |
| `cancellationPolicyText` | `?string` | Optional | The free-form text of the seller's cancellation policy.<br>**Constraints**: *Maximum Length*: `65536` | getCancellationPolicyText(): ?string | setCancellationPolicyText(?string cancellationPolicyText): void |
| `skipBookingFlowStaffSelection` | `?bool` | Optional | Indicates whether customers has an assigned staff member (`true`) or can select s staff member of their choice (`false`). | getSkipBookingFlowStaffSelection(): ?bool | setSkipBookingFlowStaffSelection(?bool skipBookingFlowStaffSelection): void |

## Example (as JSON)

```json
{
  "location_types": [
    "BUSINESS_LOCATION",
    "CUSTOMER_LOCATION"
  ],
  "alignment_time": "HALF_HOURLY",
  "min_booking_lead_time_seconds": 38,
  "max_booking_lead_time_seconds": 48,
  "any_team_member_booking_enabled": false,
  "multiple_service_booking_enabled": false,
  "max_appointments_per_day_limit_type": "PER_TEAM_MEMBER",
  "max_appointments_per_day_limit": 178,
  "cancellation_window_seconds": 72,
  "cancellation_fee_money": {
    "amount": 72,
    "currency": "COU"
  },
  "cancellation_policy": "CANCELLATION_TREATED_AS_NO_SHOW",
  "cancellation_policy_text": "cancellation_policy_text2",
  "skip_booking_flow_staff_selection": false
}
```

