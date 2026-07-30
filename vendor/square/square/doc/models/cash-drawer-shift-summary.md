
# Cash Drawer Shift Summary

The summary of a closed cash drawer shift.
This model contains only the money counted to start a cash drawer shift, counted
at the end of the shift, and the amount that should be in the drawer at shift
end based on summing all cash drawer shift events.

## Structure

`CashDrawerShiftSummary`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The shift unique ID. | getId(): ?string | setId(?string id): void |
| `state` | [`?string (CashDrawerShiftState)`](../../doc/models/cash-drawer-shift-state.md) | Optional | The current state of a cash drawer shift. | getState(): ?string | setState(?string state): void |
| `openedAt` | `?string` | Optional | The shift start time in ISO 8601 format. | getOpenedAt(): ?string | setOpenedAt(?string openedAt): void |
| `endedAt` | `?string` | Optional | The shift end time in ISO 8601 format. | getEndedAt(): ?string | setEndedAt(?string endedAt): void |
| `closedAt` | `?string` | Optional | The shift close time in ISO 8601 format. | getClosedAt(): ?string | setClosedAt(?string closedAt): void |
| `description` | `?string` | Optional | An employee free-text description of a cash drawer shift. | getDescription(): ?string | setDescription(?string description): void |
| `openedCashMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getOpenedCashMoney(): ?Money | setOpenedCashMoney(?Money openedCashMoney): void |
| `expectedCashMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getExpectedCashMoney(): ?Money | setExpectedCashMoney(?Money expectedCashMoney): void |
| `closedCashMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getClosedCashMoney(): ?Money | setClosedCashMoney(?Money closedCashMoney): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "state": "CLOSED",
  "opened_at": "opened_at8",
  "ended_at": "ended_at2",
  "closed_at": "closed_at2",
  "description": "description0",
  "opened_cash_money": {
    "amount": 158,
    "currency": "SBD"
  },
  "expected_cash_money": {
    "amount": 68,
    "currency": "CHF"
  },
  "closed_cash_money": {
    "amount": 12,
    "currency": "MRO"
  }
}
```

