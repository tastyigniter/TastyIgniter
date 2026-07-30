
# Subscription Action

Represents an action as a pending change to a subscription.

## Structure

`SubscriptionAction`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The ID of an action scoped to a subscription. | getId(): ?string | setId(?string id): void |
| `type` | [`?string (SubscriptionActionType)`](../../doc/models/subscription-action-type.md) | Optional | Supported types of an action as a pending change to a subscription. | getType(): ?string | setType(?string type): void |
| `effectiveDate` | `?string` | Optional | The `YYYY-MM-DD`-formatted date when the action occurs on the subscription. | getEffectiveDate(): ?string | setEffectiveDate(?string effectiveDate): void |
| `newPlanId` | `?string` | Optional | The target subscription plan a subscription switches to, for a `SWAP_PLAN` action. | getNewPlanId(): ?string | setNewPlanId(?string newPlanId): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "type": "RESUME",
  "effective_date": "effective_date0",
  "new_plan_id": "new_plan_id4"
}
```

