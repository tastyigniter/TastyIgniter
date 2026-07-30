
# Cancel Terminal Refund Response

## Structure

`CancelTerminalRefundResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `refund` | [`?TerminalRefund`](../../doc/models/terminal-refund.md) | Optional | Represents a payment refund processed by the Square Terminal. Only supports Interac (Canadian debit network) payment refunds. | getRefund(): ?TerminalRefund | setRefund(?TerminalRefund refund): void |

## Example (as JSON)

```json
{
  "refund": {
    "amount_money": {
      "amount": 100,
      "currency": "CAD"
    },
    "app_id": "sandbox-sq0idb-c2OuYt13YaCAeJq_2cd8OQ",
    "cancel_reason": "SELLER_CANCELED",
    "card": {
      "bin": "411111",
      "card_brand": "INTERAC",
      "card_type": "CREDIT",
      "exp_month": 1,
      "exp_year": 2022,
      "fingerprint": "sq-1-B1fP9MNNmZgVVaPKRND6oDKYbz25S2cTvg9Mzwg3RMTK1zT1PiGRT-AE3nTA8vSmmw",
      "last_4": "1111"
    },
    "created_at": "2020-10-21T22:47:23.241Z",
    "deadline_duration": "PT5M",
    "device_id": "42690809-faa2-4701-a24b-19d3d34c9aaa",
    "id": "g6ycb6HD-5O5OvgkcNUhl7JBuINflcjKqUzXZY",
    "location_id": "76C9W6K8CNNQ5",
    "order_id": "kcuKDKreRaI4gF4TjmEgZjHk8Z7YY",
    "payment_id": "5O5OvgkcNUhl7JBuINflcjKqUzXZY",
    "reason": "reason",
    "status": "CANCELED",
    "updated_at": "2020-10-21T22:47:30.096Z"
  }
}
```

