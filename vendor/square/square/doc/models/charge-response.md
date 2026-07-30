
# Charge Response

Defines the fields that are included in the response body of
a request to the [Charge](api-endpoint:Transactions-Charge) endpoint.

One of `errors` or `transaction` is present in a given response (never both).

## Structure

`ChargeResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `transaction` | [`?Transaction`](../../doc/models/transaction.md) | Optional | Represents a transaction processed with Square, either with the<br>Connect API or with Square Point of Sale.<br><br>The `tenders` field of this object lists all methods of payment used to pay in<br>the transaction. | getTransaction(): ?Transaction | setTransaction(?Transaction transaction): void |

## Example (as JSON)

```json
{
  "transaction": {
    "created_at": "2016-03-10T22:57:56Z",
    "id": "KnL67ZIwXCPtzOrqj0HrkxMF",
    "location_id": "18YC4JDH91E1H",
    "product": "EXTERNAL_API",
    "reference_id": "some optional reference id",
    "tenders": [
      {
        "additional_recipients": [
          {
            "amount_money": {
              "amount": 20,
              "currency": "USD"
            },
            "description": "Application fees",
            "location_id": "057P5VYJ4A5X1",
            "receivable_id": "ISu5xwxJ5v0CMJTQq7RvqyMF"
          }
        ],
        "amount_money": {
          "amount": 200,
          "currency": "USD"
        },
        "card_details": {
          "card": {
            "card_brand": "VISA",
            "last_4": "1111"
          },
          "entry_method": "KEYED",
          "status": "CAPTURED"
        },
        "created_at": "2016-03-10T22:57:56Z",
        "id": "MtZRYYdDrYNQbOvV7nbuBvMF",
        "location_id": "18YC4JDH91E1H",
        "note": "some optional note",
        "transaction_id": "KnL67ZIwXCPtzOrqj0HrkxMF",
        "type": "CARD"
      }
    ]
  }
}
```

