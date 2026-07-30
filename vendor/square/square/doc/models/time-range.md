
# Time Range

Represents a generic time range. The start and end values are
represented in RFC 3339 format. Time ranges are customized to be
inclusive or exclusive based on the needs of a particular endpoint.
Refer to the relevant endpoint-specific documentation to determine
how time ranges are handled.

## Structure

`TimeRange`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `startAt` | `?string` | Optional | A datetime value in RFC 3339 format indicating when the time range<br>starts. | getStartAt(): ?string | setStartAt(?string startAt): void |
| `endAt` | `?string` | Optional | A datetime value in RFC 3339 format indicating when the time range<br>ends. | getEndAt(): ?string | setEndAt(?string endAt): void |

## Example (as JSON)

```json
{
  "start_at": "start_at2",
  "end_at": "end_at0"
}
```

