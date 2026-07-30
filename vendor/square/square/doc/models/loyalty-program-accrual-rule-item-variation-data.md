
# Loyalty Program Accrual Rule Item Variation Data

Represents additional data for rules with the `ITEM_VARIATION` accrual type.

## Structure

`LoyaltyProgramAccrualRuleItemVariationData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `itemVariationId` | `string` | Required | The ID of the `ITEM_VARIATION` [catalog object](entity:CatalogObject) that buyers can purchase to earn<br>points.<br>**Constraints**: *Minimum Length*: `1` | getItemVariationId(): string | setItemVariationId(string itemVariationId): void |

## Example (as JSON)

```json
{
  "item_variation_id": "item_variation_id4"
}
```

