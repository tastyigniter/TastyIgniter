
# Search Availability Request

## Structure

`SearchAvailabilityRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`SearchAvailabilityQuery`](../../doc/models/search-availability-query.md) | Required | The query used to search for buyer-accessible availabilities of bookings. | getQuery(): SearchAvailabilityQuery | setQuery(SearchAvailabilityQuery query): void |

## Example (as JSON)

```json
{
  "query": {
    "filter": {
      "start_at_range": {
        "start_at": "start_at0",
        "end_at": "end_at2"
      },
      "location_id": "location_id8",
      "segment_filters": [
        {
          "service_variation_id": "service_variation_id0",
          "team_member_id_filter": {
            "all": [
              "all9"
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
}
```

