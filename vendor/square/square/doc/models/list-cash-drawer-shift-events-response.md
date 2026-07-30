
# List Cash Drawer Shift Events Response

## Structure

`ListCashDrawerShiftEventsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `events` | [`?(CashDrawerShiftEvent[])`](../../doc/models/cash-drawer-shift-event.md) | Optional | All of the events (payments, refunds, etc.) for a cash drawer during<br>the shift. | getEvents(): ?array | setEvents(?array events): void |
| `cursor` | `?string` | Optional | Opaque cursor for fetching the next page. Cursor is not present in<br>the last page of results. | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "events": [
    {
      "created_at": "2019-11-22T00:43:02.000Z",
      "description": "",
      "event_money": {
        "amount": 100,
        "currency": "USD"
      },
      "event_type": "CASH_TENDER_PAYMENT",
      "id": "9F07DB01-D85A-4B77-88C3-D5C64CEB5155"
    },
    {
      "created_at": "2019-11-22T00:43:12.000Z",
      "description": "",
      "event_money": {
        "amount": 250,
        "currency": "USD"
      },
      "event_type": "CASH_TENDER_PAYMENT",
      "id": "B2854CEA-A781-49B3-8F31-C64558231F48"
    },
    {
      "created_at": "2019-11-22T00:43:23.000Z",
      "description": "",
      "event_money": {
        "amount": 250,
        "currency": "USD"
      },
      "event_type": "CASH_TENDER_CANCELLED_PAYMENT",
      "id": "B5FB7F72-95CD-44A3-974D-26C41064D042"
    },
    {
      "created_at": "2019-11-22T00:43:46.000Z",
      "description": "",
      "event_money": {
        "amount": 100,
        "currency": "USD"
      },
      "event_type": "CASH_TENDER_REFUND",
      "id": "0B425480-8504-40B4-A867-37B23543931B"
    },
    {
      "created_at": "2019-11-22T00:44:18.000Z",
      "description": "Transfer from another drawer",
      "event_money": {
        "amount": 10000,
        "currency": "USD"
      },
      "event_type": "PAID_IN",
      "id": "8C66E60E-FDCF-4EEF-A98D-3B14B7ED5CBE"
    },
    {
      "created_at": "2019-11-22T00:44:29.000Z",
      "description": "Transfer out to another drawer",
      "event_money": {
        "amount": 10000,
        "currency": "USD"
      },
      "event_type": "PAID_OUT",
      "id": "D5ACA7FE-C64D-4ADA-8BC8-82118A2DAE4F"
    }
  ]
}
```

