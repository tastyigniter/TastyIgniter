
# Loyalty Program Accrual Rule

Represents an accrual rule, which defines how buyers can earn points from the base [loyalty program](../../doc/models/loyalty-program.md).

## Structure

`LoyaltyProgramAccrualRule`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `accrualType` | [`string (LoyaltyProgramAccrualRuleType)`](../../doc/models/loyalty-program-accrual-rule-type.md) | Required | The type of the accrual rule that defines how buyers can earn points. | getAccrualType(): string | setAccrualType(string accrualType): void |
| `points` | `?int` | Optional | The number of points that<br>buyers earn based on the `accrual_type`.<br>**Constraints**: `>= 1` | getPoints(): ?int | setPoints(?int points): void |
| `visitData` | [`?LoyaltyProgramAccrualRuleVisitData`](../../doc/models/loyalty-program-accrual-rule-visit-data.md) | Optional | Represents additional data for rules with the `VISIT` accrual type. | getVisitData(): ?LoyaltyProgramAccrualRuleVisitData | setVisitData(?LoyaltyProgramAccrualRuleVisitData visitData): void |
| `spendData` | [`?LoyaltyProgramAccrualRuleSpendData`](../../doc/models/loyalty-program-accrual-rule-spend-data.md) | Optional | Represents additional data for rules with the `SPEND` accrual type. | getSpendData(): ?LoyaltyProgramAccrualRuleSpendData | setSpendData(?LoyaltyProgramAccrualRuleSpendData spendData): void |
| `itemVariationData` | [`?LoyaltyProgramAccrualRuleItemVariationData`](../../doc/models/loyalty-program-accrual-rule-item-variation-data.md) | Optional | Represents additional data for rules with the `ITEM_VARIATION` accrual type. | getItemVariationData(): ?LoyaltyProgramAccrualRuleItemVariationData | setItemVariationData(?LoyaltyProgramAccrualRuleItemVariationData itemVariationData): void |
| `categoryData` | [`?LoyaltyProgramAccrualRuleCategoryData`](../../doc/models/loyalty-program-accrual-rule-category-data.md) | Optional | Represents additional data for rules with the `CATEGORY` accrual type. | getCategoryData(): ?LoyaltyProgramAccrualRuleCategoryData | setCategoryData(?LoyaltyProgramAccrualRuleCategoryData categoryData): void |

## Example (as JSON)

```json
{
  "accrual_type": "ITEM_VARIATION",
  "points": 236,
  "visit_data": {
    "minimum_amount_money": {
      "amount": 24,
      "currency": "GEL"
    },
    "tax_mode": "BEFORE_TAX"
  },
  "spend_data": {
    "amount_money": {
      "amount": 248,
      "currency": "MXV"
    },
    "excluded_category_ids": [
      "excluded_category_ids4"
    ],
    "excluded_item_variation_ids": [
      "excluded_item_variation_ids3",
      "excluded_item_variation_ids4"
    ],
    "tax_mode": "BEFORE_TAX"
  },
  "item_variation_data": {
    "item_variation_id": "item_variation_id0"
  },
  "category_data": {
    "category_id": "category_id4"
  }
}
```

