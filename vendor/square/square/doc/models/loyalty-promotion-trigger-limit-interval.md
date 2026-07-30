
# Loyalty Promotion Trigger Limit Interval

Indicates the time period that the [trigger limit](../../doc/models/loyalty-promotion-trigger-limit.md) applies to,
which is used to determine the number of times a buyer can earn points for a [loyalty promotion](../../doc/models/loyalty-promotion.md).

## Enumeration

`LoyaltyPromotionTriggerLimitInterval`

## Fields

| Name | Description |
|  --- | --- |
| `ALL_TIME` | The limit applies to the entire time that the promotion is active. For example, if `times`<br>is set to 1 and `time_period` is set to `ALL_TIME`, a buyer can earn promotion points a maximum<br>of one time during the promotion. |
| `DAY` | The limit applies per day, according to the `available_time` schedule specified for the promotion.<br>For example, if the `times` field of the trigger limit is set to 1, a buyer can trigger the promotion<br>a maximum of once per day. |

