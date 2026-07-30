
# V1 Settlement

V1Settlement

## Structure

`V1Settlement`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The settlement's unique identifier. | getId(): ?string | setId(?string id): void |
| `status` | [`?string (V1SettlementStatus)`](../../doc/models/v1-settlement-status.md) | Optional | - | getStatus(): ?string | setStatus(?string status): void |
| `totalMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalMoney(): ?V1Money | setTotalMoney(?V1Money totalMoney): void |
| `initiatedAt` | `?string` | Optional | The time when the settlement was submitted for deposit or withdrawal, in ISO 8601 format. | getInitiatedAt(): ?string | setInitiatedAt(?string initiatedAt): void |
| `bankAccountId` | `?string` | Optional | The Square-issued unique identifier for the bank account associated with the settlement. | getBankAccountId(): ?string | setBankAccountId(?string bankAccountId): void |
| `entries` | [`?(V1SettlementEntry[])`](../../doc/models/v1-settlement-entry.md) | Optional | The entries included in this settlement. | getEntries(): ?array | setEntries(?array entries): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "status": "FAILED",
  "total_money": {
    "amount": 250,
    "currency_code": "USS"
  },
  "initiated_at": "initiated_at2",
  "bank_account_id": "bank_account_id0",
  "entries": [
    {
      "payment_id": "payment_id5",
      "type": "PAID_SERVICE_FEE",
      "amount_money": {
        "amount": 91,
        "currency_code": "PEN"
      },
      "fee_money": {
        "amount": 203,
        "currency_code": "RON"
      }
    }
  ]
}
```

