
# Shift Workday

A `Shift` search query filter parameter that sets a range of days that
a `Shift` must start or end in before passing the filter condition.

## Structure

`ShiftWorkday`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `dateRange` | [`?DateRange`](../../doc/models/date-range.md) | Optional | A range defined by two dates. Used for filtering a query for Connect v2<br>objects that have date properties. | getDateRange(): ?DateRange | setDateRange(?DateRange dateRange): void |
| `matchShiftsBy` | [`?string (ShiftWorkdayMatcher)`](../../doc/models/shift-workday-matcher.md) | Optional | Defines the logic used to apply a workday filter. | getMatchShiftsBy(): ?string | setMatchShiftsBy(?string matchShiftsBy): void |
| `defaultTimezone` | `?string` | Optional | Location-specific timezones convert workdays to datetime filters.<br>Every location included in the query must have a timezone or this field<br>must be provided as a fallback. Format: the IANA timezone database<br>identifier for the relevant timezone. | getDefaultTimezone(): ?string | setDefaultTimezone(?string defaultTimezone): void |

## Example (as JSON)

```json
{
  "date_range": {
    "start_date": "start_date6",
    "end_date": "end_date2"
  },
  "match_shifts_by": "INTERSECTION",
  "default_timezone": "default_timezone6"
}
```

