
# Update Break Type Request

A request to update a `BreakType`.

## Structure

`UpdateBreakTypeRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `breakType` | [`BreakType`](../../doc/models/break-type.md) | Required | A defined break template that sets an expectation for possible `Break`<br>instances on a `Shift`. | getBreakType(): BreakType | setBreakType(BreakType breakType): void |

## Example (as JSON)

```json
{
  "break_type": {
    "break_name": "Lunch",
    "expected_duration": "PT50M",
    "is_paid": true,
    "location_id": "26M7H24AZ9N6R",
    "version": 1
  }
}
```

