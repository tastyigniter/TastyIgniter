
# List Break Types Response

The response to a request for a set of `BreakType` objects. The response contains
the requested `BreakType` objects and might contain a set of `Error` objects if
the request resulted in errors.

## Structure

`ListBreakTypesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `breakTypes` | [`?(BreakType[])`](../../doc/models/break-type.md) | Optional | A page of `BreakType` results. | getBreakTypes(): ?array | setBreakTypes(?array breakTypes): void |
| `cursor` | `?string` | Optional | The value supplied in the subsequent request to fetch the next page<br>of `BreakType` results. | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "break_types": [
    {
      "break_name": "Coffee Break",
      "created_at": "2019-01-22T20:47:37Z",
      "expected_duration": "PT5M",
      "id": "REGS1EQR1TPZ5",
      "is_paid": false,
      "location_id": "PAA1RJZZKXBFG",
      "updated_at": "2019-01-22T20:47:37Z",
      "version": 1
    },
    {
      "break_name": "Lunch Break",
      "created_at": "2019-01-25T19:26:30Z",
      "expected_duration": "PT1H",
      "id": "92EPDRQKJ5088",
      "is_paid": true,
      "location_id": "PAA1RJZZKXBFG",
      "updated_at": "2019-01-25T19:26:30Z",
      "version": 3
    }
  ],
  "cursor": "2fofTniCgT0yIPAq26kmk0YyFQJZfbWkh73OOnlTHmTAx13NgED"
}
```

