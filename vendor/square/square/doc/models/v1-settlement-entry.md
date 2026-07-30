
# V1 Settlement Entry

V1SettlementEntry

## Structure

`V1SettlementEntry`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `paymentId` | `?string` | Optional | The settlement's unique identifier. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `type` | [`?string (V1SettlementEntryType)`](../../doc/models/v1-settlement-entry-type.md) | Optional | - | getType(): ?string | setType(?string type): void |
| `amountMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getAmountMoney(): ?V1Money | setAmountMoney(?V1Money amountMoney): void |
| `feeMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getFeeMoney(): ?V1Money | setFeeMoney(?V1Money feeMoney): void |

## Example (as JSON)

```json
{
  "payment_id": "payment_id0",
  "type": "PAID_SERVICE_FEE",
  "amount_money": {
    "amount": 186,
    "currency_code": "KRW"
  },
  "fee_money": {
    "amount": 108,
    "currency_code": "UZS"
  }
}
```

