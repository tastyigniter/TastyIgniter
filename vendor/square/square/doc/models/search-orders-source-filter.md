
# Search Orders Source Filter

A filter based on order `source` information.

## Structure

`SearchOrdersSourceFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `sourceNames` | `?(string[])` | Optional | Filters by the [Source](entity:OrderSource) `name`. The filter returns any orders<br>with a `source.name` that matches any of the listed source names.<br><br>Max: 10 source names. | getSourceNames(): ?array | setSourceNames(?array sourceNames): void |

## Example (as JSON)

```json
{
  "source_names": [
    "source_names8"
  ]
}
```

