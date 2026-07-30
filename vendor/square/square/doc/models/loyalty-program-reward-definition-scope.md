
# Loyalty Program Reward Definition Scope

Indicates the scope of the reward tier. DEPRECATED at version 2020-12-16. Discount details
are now defined using a catalog pricing rule and other catalog objects. For more information, see
[Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-rewards#get-discount-details).

## Enumeration

`LoyaltyProgramRewardDefinitionScope`

## Fields

| Name | Description |
|  --- | --- |
| `ORDER` | The discount applies to the entire order. |
| `ITEM_VARIATION` | The discount applies only to specific item variations. |
| `CATEGORY` | The discount applies only to items in the given categories. |

