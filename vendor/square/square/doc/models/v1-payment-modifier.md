
# V1 Payment Modifier

V1PaymentModifier

## Structure

`V1PaymentModifier`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The modifier option's name. | getName(): ?string | setName(?string name): void |
| `appliedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getAppliedMoney(): ?V1Money | setAppliedMoney(?V1Money appliedMoney): void |
| `modifierOptionId` | `?string` | Optional | The ID of the applied modifier option, if available. Modifier options applied in older versions of Square Register might not have an ID. | getModifierOptionId(): ?string | setModifierOptionId(?string modifierOptionId): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "applied_money": {
    "amount": 196,
    "currency_code": "LYD"
  },
  "modifier_option_id": "modifier_option_id6"
}
```

