
# Swap Plan Request

Defines input parameters in a call to the
[SwapPlan](../../doc/apis/subscriptions.md#swap-plan) endpoint.

## Structure

`SwapPlanRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `newPlanId` | `string` | Required | The ID of the new subscription plan.<br>**Constraints**: *Minimum Length*: `1` | getNewPlanId(): string | setNewPlanId(string newPlanId): void |

## Example (as JSON)

```json
{
  "new_plan_id": "new_plan_id4"
}
```

