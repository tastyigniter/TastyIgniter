
# Loyalty Promotion Trigger Limit

Represents the number of times a buyer can earn points during a [loyalty promotion](../../doc/models/loyalty-promotion.md).
If this field is not set, buyers can trigger the promotion an unlimited number of times to earn points during
the time that the promotion is available.

A purchase that is disqualified from earning points because of this limit might qualify for another active promotion.

## Structure

`LoyaltyPromotionTriggerLimit`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `times` | `int` | Required | The maximum number of times a buyer can trigger the promotion during the specified `interval`.<br>**Constraints**: `>= 1`, `<= 30` | getTimes(): int | setTimes(int times): void |
| `interval` | [`?string (LoyaltyPromotionTriggerLimitInterval)`](../../doc/models/loyalty-promotion-trigger-limit-interval.md) | Optional | Indicates the time period that the [trigger limit](../../doc/models/loyalty-promotion-trigger-limit.md) applies to,<br>which is used to determine the number of times a buyer can earn points for a [loyalty promotion](../../doc/models/loyalty-promotion.md). | getInterval(): ?string | setInterval(?string interval): void |

## Example (as JSON)

```json
{
  "times": 28,
  "interval": "ALL_TIME"
}
```

