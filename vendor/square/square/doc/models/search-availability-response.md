
# Search Availability Response

## Structure

`SearchAvailabilityResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `availabilities` | [`?(Availability[])`](../../doc/models/availability.md) | Optional | List of appointment slots available for booking. | getAvailabilities(): ?array | setAvailabilities(?array availabilities): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "availabilities": [
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T13:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T13:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T14:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T14:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T15:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T15:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-26T16:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T09:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T09:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T10:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T10:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T11:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T11:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T12:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T12:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T13:00:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMXUrsBWWcHTt79t"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T13:30:00Z"
    },
    {
      "appointment_segments": [
        {
          "duration_minutes": 60,
          "service_variation_id": "RU3PBTZTK7DXZDQFCJHOK2MC",
          "service_variation_version": 1599775456731,
          "team_member_id": "TMaJcbiRqPIGZuS9"
        }
      ],
      "location_id": "LEQHH0YY8B42M",
      "start_at": "2020-11-27T14:00:00Z"
    }
  ],
  "errors": []
}
```

