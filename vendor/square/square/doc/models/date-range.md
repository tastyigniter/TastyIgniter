
# Date Range

A range defined by two dates. Used for filtering a query for Connect v2
objects that have date properties.

## Structure

`DateRange`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `startDate` | `?string` | Optional | A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601<br>extended format for calendar dates.<br>The beginning of a date range (inclusive). | getStartDate(): ?string | setStartDate(?string startDate): void |
| `endDate` | `?string` | Optional | A string in `YYYY-MM-DD` format, such as `2017-10-31`, per the ISO 8601<br>extended format for calendar dates.<br>The end of a date range (inclusive). | getEndDate(): ?string | setEndDate(?string endDate): void |

## Example (as JSON)

```json
{
  "start_date": "start_date6",
  "end_date": "end_date0"
}
```

