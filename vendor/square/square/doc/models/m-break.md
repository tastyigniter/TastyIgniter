
# M Break

A record of an employee's break during a shift.

## Structure

`MBreak`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The UUID for this object. | getId(): ?string | setId(?string id): void |
| `startAt` | `string` | Required | RFC 3339; follows the same timezone information as `Shift`. Precision up to<br>the minute is respected; seconds are truncated.<br>**Constraints**: *Minimum Length*: `1` | getStartAt(): string | setStartAt(string startAt): void |
| `endAt` | `?string` | Optional | RFC 3339; follows the same timezone information as `Shift`. Precision up to<br>the minute is respected; seconds are truncated. | getEndAt(): ?string | setEndAt(?string endAt): void |
| `breakTypeId` | `string` | Required | The `BreakType` that this `Break` was templated on.<br>**Constraints**: *Minimum Length*: `1` | getBreakTypeId(): string | setBreakTypeId(string breakTypeId): void |
| `name` | `string` | Required | A human-readable name.<br>**Constraints**: *Minimum Length*: `1` | getName(): string | setName(string name): void |
| `expectedDuration` | `string` | Required | Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of<br>the break.<br>**Constraints**: *Minimum Length*: `1` | getExpectedDuration(): string | setExpectedDuration(string expectedDuration): void |
| `isPaid` | `bool` | Required | Whether this break counts towards time worked for compensation<br>purposes. | getIsPaid(): bool | setIsPaid(bool isPaid): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "start_at": "start_at2",
  "end_at": "end_at0",
  "break_type_id": "break_type_id6",
  "name": "name0",
  "expected_duration": "expected_duration4",
  "is_paid": false
}
```

