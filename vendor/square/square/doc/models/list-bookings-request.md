
# List Bookings Request

## Structure

`ListBookingsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `limit` | `?int` | Optional | The maximum number of results per page to return in a paged response.<br>**Constraints**: `>= 1`, `<= 10000` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | The pagination cursor from the preceding response to return the next page of the results. Do not set this when retrieving the first page of the results.<br>**Constraints**: *Maximum Length*: `65536` | getCursor(): ?string | setCursor(?string cursor): void |
| `teamMemberId` | `?string` | Optional | The team member for whom to retrieve bookings. If this is not set, bookings of all members are retrieved.<br>**Constraints**: *Maximum Length*: `32` | getTeamMemberId(): ?string | setTeamMemberId(?string teamMemberId): void |
| `locationId` | `?string` | Optional | The location for which to retrieve bookings. If this is not set, all locations' bookings are retrieved.<br>**Constraints**: *Maximum Length*: `32` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `startAtMin` | `?string` | Optional | The RFC 3339 timestamp specifying the earliest of the start time. If this is not set, the current time is used. | getStartAtMin(): ?string | setStartAtMin(?string startAtMin): void |
| `startAtMax` | `?string` | Optional | The RFC 3339 timestamp specifying the latest of the start time. If this is not set, the time of 31 days after `start_at_min` is used. | getStartAtMax(): ?string | setStartAtMax(?string startAtMax): void |

## Example (as JSON)

```json
{
  "limit": 172,
  "cursor": "cursor6",
  "team_member_id": "team_member_id0",
  "location_id": "location_id4",
  "start_at_min": "start_at_min8",
  "start_at_max": "start_at_max8"
}
```

