
# Loyalty Event Expire Points

Provides metadata when the event `type` is `EXPIRE_POINTS`.

## Structure

`LoyaltyEventExpirePoints`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `loyaltyProgramId` | `string` | Required | The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `36` | getLoyaltyProgramId(): string | setLoyaltyProgramId(string loyaltyProgramId): void |
| `points` | `int` | Required | The number of points expired. | getPoints(): int | setPoints(int points): void |

## Example (as JSON)

```json
{
  "loyalty_program_id": "loyalty_program_id0",
  "points": 236
}
```

