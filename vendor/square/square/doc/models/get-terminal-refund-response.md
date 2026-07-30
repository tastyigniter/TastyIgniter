
# Get Terminal Refund Response

## Structure

`GetTerminalRefundResponse`

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
      "amount": 111,
      "currency": "CAD"
    },
    "app_id": "sandbox-sq0idb-c2OuYt13YaCAeJq_2cd8OQ",
    "card": {
      "bin": "411111",
      "card_brand": "INTERAC",
      "card_type": "CREDIT",
      "exp_month": 1,
      "exp_year": 2022,
      "fingerprint": "sq-1-B1fP9MNNmZgVVaPKRND6oDKYbz25S2cTvg9Mzwg3RMTK1zT1PiGRT-AE3nTA8vSmmw",
      "last_4": "1111"
    },
    "created_at": "2020-09-29T15:21:46.771Z",
    "deadline_duration": "PT5M",
    "device_id": "f72dfb8e-4d65-4e56-aade-ec3fb8d33291",
    "id": "009DP5HD-5O5OvgkcNUhl7JBuINflcjKqUzXZY",
    "location_id": "76C9W6K8CNNQ5",
    "order_id": "kcuKDKreRaI4gF4TjmEgZjHk8Z7YY",
    "payment_id": "5O5OvgkcNUhl7JBuINflcjKqUzXZY",
    "reason": "Returning item",
    "refund_id": "5O5OvgkcNUhl7JBuINflcjKqUzXZY_43Q4iGp7sNeATiWrUruA1EYeMRUXaddXXlDDJ1EQLvb",
    "status": "COMPLETED",
    "updated_at": "2020-09-29T15:21:48.675Z"
  }
}
```

