
# Workweek Config

Sets the day of the week and hour of the day that a business starts a
workweek. This is used to calculate overtime pay.

## Structure

`WorkweekConfig`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The UUID for this object. | getId(): ?string | setId(?string id): void |
| `startOfWeek` | [`string (Weekday)`](../../doc/models/weekday.md) | Required | The days of the week. | getStartOfWeek(): string | setStartOfWeek(string startOfWeek): void |
| `startOfDayLocalTime` | `string` | Required | The local time at which a business week starts. Represented as a<br>string in `HH:MM` format (`HH:MM:SS` is also accepted, but seconds are<br>truncated).<br>**Constraints**: *Minimum Length*: `1` | getStartOfDayLocalTime(): string | setStartOfDayLocalTime(string startOfDayLocalTime): void |
| `version` | `?int` | Optional | Used for resolving concurrency issues. The request fails if the version<br>provided does not match the server version at the time of the request. If not provided,<br>Square executes a blind write; potentially overwriting data from another<br>write. | getVersion(): ?int | setVersion(?int version): void |
| `createdAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format; presented in UTC. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format; presented in UTC. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "start_of_week": "MON",
  "start_of_day_local_time": "start_of_day_local_time6",
  "version": 172,
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

