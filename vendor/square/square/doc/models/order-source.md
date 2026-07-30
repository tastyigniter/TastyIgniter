
# Order Source

Represents the origination details of an order.

## Structure

`OrderSource`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The name used to identify the place (physical or digital) that an order originates.<br>If unset, the name defaults to the name of the application that created the order. | getName(): ?string | setName(?string name): void |

## Example (as JSON)

```json
{
  "name": "name0"
}
```

