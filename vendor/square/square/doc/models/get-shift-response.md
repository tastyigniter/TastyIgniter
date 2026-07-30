
# Get Shift Response

A response to a request to get a `Shift`. The response contains
the requested `Shift` object and might contain a set of `Error` objects if
the request resulted in errors.

## Structure

`GetShiftResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `shift` | [`?Shift`](../../doc/models/shift.md) | Optional | A record of the hourly rate, start, and end times for a single work shift<br>for an employee. This might include a record of the start and end times for breaks<br>taken during the shift. | getShift(): ?Shift | setShift(?Shift shift): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "shift": {
    "breaks": [
      {
        "break_type_id": "92EPDRQKJ5088",
        "end_at": "2019-02-23T20:00:00-05:00",
        "expected_duration": "PT1H",
        "id": "M9BBKEPQAQD2T",
        "is_paid": true,
        "name": "Lunch Break",
        "start_at": "2019-02-23T19:00:00-05:00"
      }
    ],
    "created_at": "2019-02-27T00:12:12Z",
    "employee_id": "D71KRMQof6cXGUW0aAv7",
    "end_at": "2019-02-23T21:00:00-05:00",
    "id": "T35HMQSN89SV4",
    "location_id": "PAA1RJZZKXBFG",
    "start_at": "2019-02-23T18:00:00-05:00",
    "status": "CLOSED",
    "team_member_id": "D71KRMQof6cXGUW0aAv7",
    "timezone": "America/New_York",
    "updated_at": "2019-02-27T00:12:12Z",
    "version": 1,
    "wage": {
      "hourly_rate": {
        "amount": 1457,
        "currency": "USD"
      },
      "title": "Cashier"
    }
  }
}
```

