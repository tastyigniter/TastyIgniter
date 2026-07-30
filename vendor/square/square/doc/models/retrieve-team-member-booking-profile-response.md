
# Retrieve Team Member Booking Profile Response

## Structure

`RetrieveTeamMemberBookingProfileResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `teamMemberBookingProfile` | [`?TeamMemberBookingProfile`](../../doc/models/team-member-booking-profile.md) | Optional | The booking profile of a seller's team member, including the team member's ID, display name, description and whether the team member can be booked as a service provider. | getTeamMemberBookingProfile(): ?TeamMemberBookingProfile | setTeamMemberBookingProfile(?TeamMemberBookingProfile teamMemberBookingProfile): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "errors": [],
  "team_member_booking_profile": {
    "display_name": "Sandbox Staff",
    "is_bookable": true,
    "team_member_id": "TMaJcbiRqPIGZuS9"
  }
}
```

