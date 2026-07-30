
# Gift Card Activity Redeem Status

Indicates the status of a [gift card](../../doc/models/gift-card.md) redemption. This status is relevant only for
redemptions made from Square products (such as Square Point of Sale) because Square products use a
two-state process. Gift cards redeemed using the Gift Card Activities API always have a `COMPLETED` status.

## Enumeration

`GiftCardActivityRedeemStatus`

## Fields

| Name | Description |
|  --- | --- |
| `PENDING` | The gift card redemption is pending. `PENDING` is a temporary status that applies when a<br>gift card is redeemed from Square Point of Sale or another Square product. A `PENDING` status is updated to<br>`COMPLETED` if the payment is captured or `CANCELED` if the authorization is voided. |
| `COMPLETED` | The gift card redemption is completed. |
| `CANCELED` | The gift card redemption is canceled. A redemption is canceled if the authorization<br>on the gift card is voided. |

