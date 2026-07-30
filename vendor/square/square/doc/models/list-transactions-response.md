
# List Transactions Response

Defines the fields that are included in the response body of
a request to the [ListTransactions](api-endpoint:Transactions-ListTransactions) endpoint.

One of `errors` or `transactions` is present in a given response (never both).

## Structure

`ListTransactionsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `transactions` | [`?(Transaction[])`](../../doc/models/transaction.md) | Optional | An array of transactions that match your query. | getTransactions(): ?array | setTransactions(?array transactions): void |
| `cursor` | `?string` | Optional | A pagination cursor for retrieving the next set of results,<br>if any remain. Provide this value as the `cursor` parameter in a subsequent<br>request to this endpoint.<br><br>See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "transactions": [
    {
      "created_at": "2016-01-20T22:57:56Z",
      "id": "KnL67ZIwXCPtzOrqj0HrkxMF",
      "location_id": "18YC4JDH91E1H",
      "product": "EXTERNAL_API",
      "reference_id": "some optional reference id",
      "refunds": [
        {
          "additional_recipients": [
            {
              "amount_money": {
                "amount": 100,
                "currency": "USD"
              },
              "description": "Application fees",
              "location_id": "057P5VYJ4A5X1"
            }
          ],
          "amount_money": {
            "amount": 5000,
            "currency": "USD"
          },
          "created_at": "2016-01-20T22:59:20Z",
          "id": "7a5RcVI0CxbOcJ2wMOkE",
          "location_id": "18YC4JDH91E1H",
          "processing_fee_money": {
            "amount": 138,
            "currency": "USD"
          },
          "reason": "some reason why",
          "status": "APPROVED",
          "tender_id": "MtZRYYdDrYNQbOvV7nbuBvMF",
          "transaction_id": "KnL67ZIwXCPtzOrqj0HrkxMF"
        }
      ],
      "tenders": [
        {
          "additional_recipients": [
            {
              "amount_money": {
                "amount": 20,
                "currency": "USD"
              },
              "description": "Application fees",
              "location_id": "057P5VYJ4A5X1"
            }
          ],
          "amount_money": {
            "amount": 5000,
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
          "created_at": "2016-01-20T22:57:56Z",
          "id": "MtZRYYdDrYNQbOvV7nbuBvMF",
          "location_id": "18YC4JDH91E1H",
          "note": "some optional note",
          "processing_fee_money": {
            "amount": 138,
            "currency": "USD"
          },
          "transaction_id": "KnL67ZIwXCPtzOrqj0HrkxMF",
          "type": "CARD"
        }
      ]
    }
  ]
}
```

