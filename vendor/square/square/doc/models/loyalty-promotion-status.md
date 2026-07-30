
# Loyalty Promotion Status

Indicates the status of a [loyalty promotion](../../doc/models/loyalty-promotion.md).

## Enumeration

`LoyaltyPromotionStatus`

## Fields

| Name | Description |
|  --- | --- |
| `ACTIVE` | The loyalty promotion is currently active. Buyers can earn points for purchases<br>that meet the promotion conditions, such as the promotion's `available_time`. |
| `ENDED` | The loyalty promotion has ended because the specified `end_date` was reached.<br>`ENDED` is a terminal status. |
| `CANCELED` | The loyalty promotion was canceled. `CANCELED` is a terminal status. |
| `SCHEDULED` | The loyalty promotion is scheduled to start in the future. Square changes the<br>promotion status to `ACTIVE` when the `start_date` is reached. |

