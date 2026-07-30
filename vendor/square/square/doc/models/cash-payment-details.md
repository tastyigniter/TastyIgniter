
# Cash Payment Details

Stores details about a cash payment. Contains only non-confidential information. For more information, see
[Take Cash Payments](https://developer.squareup.com/docs/payments-api/take-payments/cash-payments).

## Structure

`CashPaymentDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `buyerSuppliedMoney` | [`Money`](../../doc/models/money.md) | Required | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getBuyerSuppliedMoney(): Money | setBuyerSuppliedMoney(Money buyerSuppliedMoney): void |
| `changeBackMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getChangeBackMoney(): ?Money | setChangeBackMoney(?Money changeBackMoney): void |

## Example (as JSON)

```json
{
  "buyer_supplied_money": {
    "amount": 114,
    "currency": "UNKNOWN_CURRENCY"
  },
  "change_back_money": {
    "amount": 78,
    "currency": "MUR"
  }
}
```

