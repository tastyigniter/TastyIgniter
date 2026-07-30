
# Subscription Source

The origination details of the subscription.

## Structure

`SubscriptionSource`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The name used to identify the place (physical or digital) that<br>a subscription originates. If unset, the name defaults to the name<br>of the application that created the subscription.<br>**Constraints**: *Maximum Length*: `255` | getName(): ?string | setName(?string name): void |

## Example (as JSON)

```json
{
  "name": "name0"
}
```

