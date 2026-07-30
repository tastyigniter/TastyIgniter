
# List Team Member Booking Profiles Request

## Structure

`ListTeamMemberBookingProfilesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `bookableOnly` | `?bool` | Optional | Indicates whether to include only bookable team members in the returned result (`true`) or not (`false`). | getBookableOnly(): ?bool | setBookableOnly(?bool bookableOnly): void |
| `limit` | `?int` | Optional | The maximum number of results to return in a paged response.<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | The pagination cursor from the preceding response to return the next page of the results. Do not set this when retrieving the first page of the results.<br>**Constraints**: *Maximum Length*: `65536` | getCursor(): ?string | setCursor(?string cursor): void |
| `locationId` | `?string` | Optional | Indicates whether to include only team members enabled at the given location in the returned result.<br>**Constraints**: *Maximum Length*: `32` | getLocationId(): ?string | setLocationId(?string locationId): void |

## Example (as JSON)

```json
{
  "bookable_only": false,
  "limit": 172,
  "cursor": "cursor6",
  "location_id": "location_id4"
}
```

