
# Search Availability Query

The query used to search for buyer-accessible availabilities of bookings.

## Structure

`SearchAvailabilityQuery`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filter` | [`SearchAvailabilityFilter`](../../doc/models/search-availability-filter.md) | Required | A query filter to search for buyer-accessible availabilities by. | getFilter(): SearchAvailabilityFilter | setFilter(SearchAvailabilityFilter filter): void |

## Example (as JSON)

```json
{
  "filter": {
    "start_at_range": {
      "start_at": "start_at0",
      "end_at": "end_at2"
    },
    "location_id": "location_id8",
    "segment_filters": [
      {
        "service_variation_id": "service_variation_id8",
        "team_member_id_filter": {
          "all": [
            "all9",
            "all8",
            "all7"
          ],
          "any": [
            "any6",
            "any7",
            "any8"
          ],
          "none": [
            "none1",
            "none2"
          ]
        }
      },
      {
        "service_variation_id": "service_variation_id9",
        "team_member_id_filter": {
          "all": [
            "all0",
            "all9"
          ],
          "any": [
            "any7"
          ],
          "none": [
            "none2",
            "none3",
            "none4"
          ]
        }
      },
      {
        "service_variation_id": "service_variation_id0",
        "team_member_id_filter": {
          "all": [
            "all1"
          ],
          "any": [
            "any8",
            "any9"
          ],
          "none": [
            "none3"
          ]
        }
      }
    ],
    "booking_id": "booking_id8"
  }
}
```

