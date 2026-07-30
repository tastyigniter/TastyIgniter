
# Search Terminal Checkouts Response

## Structure

`SearchTerminalCheckoutsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `checkouts` | [`?(TerminalCheckout[])`](../../doc/models/terminal-checkout.md) | Optional | The requested search result of `TerminalCheckout` objects. | getCheckouts(): ?array | setCheckouts(?array checkouts): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If empty,<br>this is the final response.<br><br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "checkouts": [
    {
      "amount_money": {
        "amount": 2610,
        "currency": "USD"
      },
      "app_id": "APP_ID",
      "created_at": "2020-03-31T18:13:15.921Z",
      "deadline_duration": "PT10M",
      "device_options": {
        "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
        "skip_receipt_screen": false,
        "tip_settings": {
          "allow_tipping": false
        }
      },
      "id": "tsQPvzwBpMqqO",
      "note": "A brief note",
      "payment_ids": [
        "rXnhZzywrEk4vR6pw76fPZfgvaB"
      ],
      "reference_id": "id14467",
      "status": "COMPLETED",
      "updated_at": "2020-03-31T18:13:52.725Z"
    },
    {
      "amount_money": {
        "amount": 2610,
        "currency": "USD"
      },
      "app_id": "APP_ID",
      "created_at": "2020-03-31T18:08:31.882Z",
      "deadline_duration": "PT10M",
      "device_options": {
        "device_id": "dbb5d83a-7838-11ea-bc55-0242ac130003",
        "skip_receipt_screen": true,
        "tip_settings": {
          "allow_tipping": false
        }
      },
      "id": "XlOPTgcEhrbqO",
      "note": "A brief note",
      "payment_ids": [
        "VYBF861PaoKPP7Pih0TlbZiNvaB"
      ],
      "reference_id": "id41623",
      "status": "COMPLETED",
      "updated_at": "2020-03-31T18:08:41.635Z"
    }
  ],
  "cursor": "RiTJqBoTuXlbLmmrPvEkX9iG7XnQ4W4RjGnH"
}
```

