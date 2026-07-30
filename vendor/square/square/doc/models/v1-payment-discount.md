
# V1 Payment Discount

V1PaymentDiscount

## Structure

`V1PaymentDiscount`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The discount's name. | getName(): ?string | setName(?string name): void |
| `appliedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getAppliedMoney(): ?V1Money | setAppliedMoney(?V1Money appliedMoney): void |
| `discountId` | `?string` | Optional | The ID of the applied discount, if available. Discounts applied in older versions of Square Register might not have an ID. | getDiscountId(): ?string | setDiscountId(?string discountId): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "applied_money": {
    "amount": 196,
    "currency_code": "LYD"
  },
  "discount_id": "discount_id8"
}
```

