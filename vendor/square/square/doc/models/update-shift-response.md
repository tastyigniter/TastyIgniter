
# Update Shift Response

The response to a request to update a `Shift`. The response contains
the updated `Shift` object and might contain a set of `Error` objects if
the request resulted in errors.

## Structure

`UpdateShiftResponse`

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
        "break_type_id": "REGS1EQR1TPZ5",
        "end_at": "2019-01-25T06:16:00-05:00",
        "expected_duration": "PT5M",
        "id": "X7GAQYVVRRG6P",
        "is_paid": true,
        "name": "Tea Break",
        "start_at": "2019-01-25T06:11:00-05:00"
      }
    ],
    "created_at": "2019-02-28T00:39:02Z",
    "employee_id": "ormj0jJJZ5OZIzxrZYJI",
    "end_at": "2019-01-25T13:11:00-05:00",
    "id": "K0YH4CV5462JB",
    "location_id": "PAA1RJZZKXBFG",
    "start_at": "2019-01-25T03:11:00-05:00",
    "status": "CLOSED",
    "team_member_id": "ormj0jJJZ5OZIzxrZYJI",
    "timezone": "America/New_York",
    "updated_at": "2019-02-28T00:42:41Z",
    "version": 2,
    "wage": {
      "hourly_rate": {
        "amount": 1500,
        "currency": "USD"
      },
      "title": "Bartender"
    }
  }
}
```

