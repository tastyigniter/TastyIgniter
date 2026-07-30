
# Gift Card Status

Indicates the gift card state.

## Enumeration

`GiftCardStatus`

## Fields

| Name | Description |
|  --- | --- |
| `ACTIVE` | The gift card is active and can be used as a payment source. |
| `DEACTIVATED` | Any activity that changes the gift card balance is permanently forbidden. |
| `BLOCKED` | Any activity that changes the gift card balance is temporarily forbidden. |
| `PENDING` | The gift card is pending activation.<br>This is the initial state when a gift card is created. You must activate the gift card<br>before it can be used. |

