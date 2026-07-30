
# Loyalty Promotion Incentive Points Addition Data

Represents the metadata for a `POINTS_ADDITION` type of [loyalty promotion incentive](../../doc/models/loyalty-promotion-incentive.md).

## Structure

`LoyaltyPromotionIncentivePointsAdditionData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `pointsAddition` | `int` | Required | The number of additional points to earn each time the promotion is triggered. For example,<br>suppose a purchase qualifies for 5 points from the base loyalty program. If the purchase also<br>qualifies for a `POINTS_ADDITION` promotion incentive with a `points_addition` of 3, the buyer<br>earns a total of 8 points (5 program points + 3 promotion points = 8 points).<br>**Constraints**: `>= 1` | getPointsAddition(): int | setPointsAddition(int pointsAddition): void |

## Example (as JSON)

```json
{
  "points_addition": 176
}
```

