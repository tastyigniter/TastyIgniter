
# Update Location Request

The request object for the [UpdateLocation](../../doc/apis/locations.md#update-location) endpoint.

## Structure

`UpdateLocationRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `location` | [`?Location`](../../doc/models/location.md) | Optional | Represents one of a business' [locations](https://developer.squareup.com/docs/locations-api). | getLocation(): ?Location | setLocation(?Location location): void |

## Example (as JSON)

```json
{
  "location": {
    "business_hours": {
      "periods": [
        {
          "day_of_week": "FRI",
          "end_local_time": "18:00",
          "start_local_time": "07:00"
        },
        {
          "day_of_week": "SAT",
          "end_local_time": "18:00",
          "start_local_time": "07:00"
        },
        {
          "day_of_week": "SUN",
          "end_local_time": "15:00",
          "start_local_time": "09:00"
        }
      ]
    },
    "description": "Midtown Atlanta store - Open weekends"
  }
}
```

