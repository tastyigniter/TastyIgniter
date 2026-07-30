
# Shift Filter

Defines a filter used in a search for `Shift` records. `AND` logic is
used by Square's servers to apply each filter property specified.

## Structure

`ShiftFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationIds` | `?(string[])` | Optional | Fetch shifts for the specified location. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `employeeIds` | `?(string[])` | Optional | Fetch shifts for the specified employees. DEPRECATED at version 2020-08-26. Use `team_member_ids` instead. | getEmployeeIds(): ?array | setEmployeeIds(?array employeeIds): void |
| `status` | [`?string (ShiftFilterStatus)`](../../doc/models/shift-filter-status.md) | Optional | Specifies the `status` of `Shift` records to be returned. | getStatus(): ?string | setStatus(?string status): void |
| `start` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getStart(): ?TimeRange | setStart(?TimeRange start): void |
| `end` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getEnd(): ?TimeRange | setEnd(?TimeRange end): void |
| `workday` | [`?ShiftWorkday`](../../doc/models/shift-workday.md) | Optional | A `Shift` search query filter parameter that sets a range of days that<br>a `Shift` must start or end in before passing the filter condition. | getWorkday(): ?ShiftWorkday | setWorkday(?ShiftWorkday workday): void |
| `teamMemberIds` | `?(string[])` | Optional | Fetch shifts for the specified team members. Replaced `employee_ids` at version "2020-08-26". | getTeamMemberIds(): ?array | setTeamMemberIds(?array teamMemberIds): void |

## Example (as JSON)

```json
{
  "location_ids": [
    "location_ids0"
  ],
  "employee_ids": [
    "employee_ids5"
  ],
  "status": "OPEN",
  "start": {
    "start_at": "start_at6",
    "end_at": "end_at6"
  },
  "end": {
    "start_at": "start_at0",
    "end_at": "end_at2"
  },
  "workday": {
    "date_range": {
      "start_date": "start_date0",
      "end_date": "end_date6"
    },
    "match_shifts_by": "START_AT",
    "default_timezone": "default_timezone0"
  },
  "team_member_ids": [
    "team_member_ids7",
    "team_member_ids8"
  ]
}
```

