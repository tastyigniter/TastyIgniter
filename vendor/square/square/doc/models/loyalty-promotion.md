
# Loyalty Promotion

Represents a promotion for a [loyalty program](../../doc/models/loyalty-program.md). Loyalty promotions enable buyers
to earn extra points on top of those earned from the base program.

A loyalty program can have a maximum of 10 loyalty promotions with an `ACTIVE` or `SCHEDULED` status.

## Structure

`LoyaltyPromotion`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the promotion.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getId(): ?string | setId(?string id): void |
| `name` | `string` | Required | The name of the promotion.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `50` | getName(): string | setName(string name): void |
| `incentive` | [`LoyaltyPromotionIncentive`](../../doc/models/loyalty-promotion-incentive.md) | Required | Represents how points for a [loyalty promotion](../../doc/models/loyalty-promotion.md) are calculated,<br>either by multiplying the points earned from the base program or by adding a specified number<br>of points to the points earned from the base program. | getIncentive(): LoyaltyPromotionIncentive | setIncentive(LoyaltyPromotionIncentive incentive): void |
| `availableTime` | [`LoyaltyPromotionAvailableTimeData`](../../doc/models/loyalty-promotion-available-time-data.md) | Required | Represents scheduling information that determines when purchases can qualify to earn points<br>from a [loyalty promotion](../../doc/models/loyalty-promotion.md). | getAvailableTime(): LoyaltyPromotionAvailableTimeData | setAvailableTime(LoyaltyPromotionAvailableTimeData availableTime): void |
| `triggerLimit` | [`?LoyaltyPromotionTriggerLimit`](../../doc/models/loyalty-promotion-trigger-limit.md) | Optional | Represents the number of times a buyer can earn points during a [loyalty promotion](../../doc/models/loyalty-promotion.md).<br>If this field is not set, buyers can trigger the promotion an unlimited number of times to earn points during<br>the time that the promotion is available.<br><br>A purchase that is disqualified from earning points because of this limit might qualify for another active promotion. | getTriggerLimit(): ?LoyaltyPromotionTriggerLimit | setTriggerLimit(?LoyaltyPromotionTriggerLimit triggerLimit): void |
| `status` | [`?string (LoyaltyPromotionStatus)`](../../doc/models/loyalty-promotion-status.md) | Optional | Indicates the status of a [loyalty promotion](../../doc/models/loyalty-promotion.md). | getStatus(): ?string | setStatus(?string status): void |
| `createdAt` | `?string` | Optional | The timestamp of when the promotion was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `canceledAt` | `?string` | Optional | The timestamp of when the promotion was canceled, in RFC 3339 format. | getCanceledAt(): ?string | setCanceledAt(?string canceledAt): void |
| `updatedAt` | `?string` | Optional | The timestamp when the promotion was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `loyaltyProgramId` | `?string` | Optional | The ID of the [loyalty program](entity:LoyaltyProgram) associated with the promotion. | getLoyaltyProgramId(): ?string | setLoyaltyProgramId(?string loyaltyProgramId): void |
| `minimumSpendAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getMinimumSpendAmountMoney(): ?Money | setMinimumSpendAmountMoney(?Money minimumSpendAmountMoney): void |
| `qualifyingItemVariationIds` | `?(string[])` | Optional | The IDs of any qualifying `ITEM_VARIATION` [catalog objects](entity:CatalogObject). If specified,<br>the purchase must include at least one of these items to qualify for the promotion.<br><br>This option is valid only if the base loyalty program uses a `VISIT` or `SPEND` accrual rule.<br>With `SPEND` accrual rules, make sure that qualifying promotional items are not excluded.<br><br>You can specify `qualifying_item_variation_ids` or `qualifying_category_ids` for a given promotion, but not both. | getQualifyingItemVariationIds(): ?array | setQualifyingItemVariationIds(?array qualifyingItemVariationIds): void |
| `qualifyingCategoryIds` | `?(string[])` | Optional | The IDs of any qualifying `CATEGORY` [catalog objects](entity:CatalogObject). If specified,<br>the purchase must include at least one item from one of these categories to qualify for the promotion.<br><br>This option is valid only if the base loyalty program uses a `VISIT` or `SPEND` accrual rule.<br>With `SPEND` accrual rules, make sure that qualifying promotional items are not excluded.<br><br>You can specify `qualifying_category_ids` or `qualifying_item_variation_ids` for a promotion, but not both. | getQualifyingCategoryIds(): ?array | setQualifyingCategoryIds(?array qualifyingCategoryIds): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "name": "name0",
  "incentive": {
    "type": "POINTS_MULTIPLIER",
    "points_multiplier_data": {
      "points_multiplier": 16
    },
    "points_addition_data": {
      "points_addition": 16
    }
  },
  "available_time": {
    "start_date": "start_date4",
    "end_date": "end_date8",
    "time_periods": [
      "time_periods9"
    ]
  },
  "trigger_limit": {
    "times": 26,
    "interval": "ALL_TIME"
  },
  "status": "ACTIVE",
  "created_at": "created_at2",
  "canceled_at": "canceled_at4",
  "updated_at": "updated_at4",
  "loyalty_program_id": "loyalty_program_id0",
  "minimum_spend_amount_money": {
    "amount": 228,
    "currency": "ZMW"
  },
  "qualifying_item_variation_ids": [
    "qualifying_item_variation_ids5",
    "qualifying_item_variation_ids6"
  ],
  "qualifying_category_ids": [
    "qualifying_category_ids2",
    "qualifying_category_ids3",
    "qualifying_category_ids4"
  ]
}
```

