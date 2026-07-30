
# V1 List Settlements Response

## Structure

`V1ListSettlementsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `items` | [`?(V1Settlement[])`](../../doc/models/v1-settlement.md) | Optional | - | getItems(): ?array | setItems(?array items): void |

## Example (as JSON)

```json
{
  "items": [
    {
      "id": "id7",
      "status": "SENT",
      "total_money": {
        "amount": 53,
        "currency_code": "PGK"
      },
      "initiated_at": "initiated_at9",
      "bank_account_id": "bank_account_id7",
      "entries": [
        {
          "payment_id": "payment_id2",
          "type": "SUBSCRIPTION_FEE_REFUND",
          "amount_money": {
            "amount": 84,
            "currency_code": "AOA"
          },
          "fee_money": {}
        }
      ]
    },
    {
      "id": "id8",
      "status": "FAILED",
      "total_money": {
        "amount": 54,
        "currency_code": "PHP"
      },
      "initiated_at": "initiated_at0",
      "bank_account_id": "bank_account_id8",
      "entries": [
        {
          "payment_id": "payment_id3",
          "type": "SUBSCRIPTION_FEE",
          "amount_money": {
            "amount": 85,
            "currency_code": "ARS"
          },
          "fee_money": {}
        },
        {
          "payment_id": "payment_id2",
          "type": "SUBSCRIPTION_FEE_REFUND",
          "amount_money": {
            "amount": 84,
            "currency_code": "AOA"
          },
          "fee_money": {}
        },
        {
          "payment_id": "payment_id1",
          "type": "OTHER",
          "amount_money": {
            "amount": 83,
            "currency_code": "ANG"
          },
          "fee_money": {}
        }
      ]
    }
  ]
}
```

