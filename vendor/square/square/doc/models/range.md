
# Range

The range of a number value between the specified lower and upper bounds.

## Structure

`Range`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `min` | `?string` | Optional | The lower bound of the number range. At least one of `min` or `max` must be specified.<br>If unspecified, the results will have no minimum value. | getMin(): ?string | setMin(?string min): void |
| `max` | `?string` | Optional | The upper bound of the number range. At least one of `min` or `max` must be specified.<br>If unspecified, the results will have no maximum value. | getMax(): ?string | setMax(?string max): void |

## Example (as JSON)

```json
{
  "min": "min2",
  "max": "max0"
}
```

