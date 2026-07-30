
# Search Shifts Request

A request for a filtered and sorted set of `Shift` objects.

## Structure

`SearchShiftsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`?ShiftQuery`](../../doc/models/shift-query.md) | Optional | The parameters of a `Shift` search query, which includes filter and sort options. | getQuery(): ?ShiftQuery | setQuery(?ShiftQuery query): void |
| `limit` | `?int` | Optional | The number of resources in a page (200 by default).<br>**Constraints**: `>= 1`, `<= 200` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | An opaque cursor for fetching the next page. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "limit": 100,
  "query": {
    "filter": {
      "workday": {
        "date_range": {
          "end_date": "2019-02-03",
          "start_date": "2019-01-20"
        },
        "default_timezone": "America/Los_Angeles",
        "match_shifts_by": "START_AT"
      }
    }
  }
}
```

