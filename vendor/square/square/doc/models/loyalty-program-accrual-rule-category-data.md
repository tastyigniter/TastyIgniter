
# Loyalty Program Accrual Rule Category Data

Represents additional data for rules with the `CATEGORY` accrual type.

## Structure

`LoyaltyProgramAccrualRuleCategoryData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `categoryId` | `string` | Required | The ID of the `CATEGORY` [catalog object](entity:CatalogObject) that buyers can purchase to earn<br>points.<br>**Constraints**: *Minimum Length*: `1` | getCategoryId(): string | setCategoryId(string categoryId): void |

## Example (as JSON)

```json
{
  "category_id": "category_id8"
}
```

