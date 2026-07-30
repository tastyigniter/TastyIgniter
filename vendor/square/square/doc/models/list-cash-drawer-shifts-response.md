
# List Cash Drawer Shifts Response

## Structure

`ListCashDrawerShiftsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `items` | [`?(CashDrawerShiftSummary[])`](../../doc/models/cash-drawer-shift-summary.md) | Optional | A collection of CashDrawerShiftSummary objects for shifts that match<br>the query. | getItems(): ?array | setItems(?array items): void |
| `cursor` | `?string` | Optional | Opaque cursor for fetching the next page of results. Cursor is not<br>present in the last page of results. | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "items": [
    {
      "closed_at": "2019-11-22T00:44:49.000Z",
      "closed_cash_money": {
        "amount": 9970,
        "currency": "USD"
      },
      "description": "Misplaced some change",
      "ended_at": "2019-11-22T00:44:49.000Z",
      "expected_cash_money": {
        "amount": 10000,
        "currency": "USD"
      },
      "id": "DCC99978-09A6-4926-849F-300BE9C5793A",
      "opened_at": "2019-11-22T00:42:54.000Z",
      "opened_cash_money": {
        "amount": 10000,
        "currency": "USD"
      },
      "state": "CLOSED"
    }
  ]
}
```

