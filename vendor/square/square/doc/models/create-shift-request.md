
# Create Shift Request

Represents a request to create a `Shift`.

## Structure

`CreateShiftRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string value to ensure the idempotency of the operation.<br>**Constraints**: *Maximum Length*: `128` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `shift` | [`Shift`](../../doc/models/shift.md) | Required | A record of the hourly rate, start, and end times for a single work shift<br>for an employee. This might include a record of the start and end times for breaks<br>taken during the shift. | getShift(): Shift | setShift(Shift shift): void |

## Example (as JSON)

```json
{
  "idempotency_key": "HIDSNG5KS478L",
  "shift": {
    "breaks": [
      {
        "break_type_id": "REGS1EQR1TPZ5",
        "end_at": "2019-01-25T06:16:00-05:00",
        "expected_duration": "PT5M",
        "is_paid": true,
        "name": "Tea Break",
        "start_at": "2019-01-25T06:11:00-05:00"
      }
    ],
    "end_at": "2019-01-25T13:11:00-05:00",
    "location_id": "PAA1RJZZKXBFG",
    "start_at": "2019-01-25T03:11:00-05:00",
    "team_member_id": "ormj0jJJZ5OZIzxrZYJI",
    "wage": {
      "hourly_rate": {
        "amount": 1100,
        "currency": "USD"
      },
      "title": "Barista"
    }
  }
}
```

