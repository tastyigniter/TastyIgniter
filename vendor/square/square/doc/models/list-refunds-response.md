
# List Refunds Response

Defines the fields that are included in the response body of
a request to the [ListRefunds](api-endpoint:Transactions-ListRefunds) endpoint.

One of `errors` or `refunds` is present in a given response (never both).

## Structure

`ListRefundsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `refunds` | [`?(Refund[])`](../../doc/models/refund.md) | Optional | An array of refunds that match your query. | getRefunds(): ?array | setRefunds(?array refunds): void |
| `cursor` | `?string` | Optional | A pagination cursor for retrieving the next set of results,<br>if any remain. Provide this value as the `cursor` parameter in a subsequent<br>request to this endpoint.<br><br>See [Paginating results](https://developer.squareup.com/docs/working-with-apis/pagination) for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "refunds": [
    {
      "additional_recipients": [
        {
          "amount_money": {
            "amount": 10,
            "currency": "USD"
          },
          "description": "Application fees",
          "location_id": "057P5VYJ4A5X1"
        }
      ],
      "amount_money": {
        "amount": 100,
        "currency": "USD"
      },
      "created_at": "2016-01-20T00:28:18Z",
      "id": "b27436d1-7f8e-5610-45c6-417ef71434b4-SW",
      "location_id": "18YC4JDH91E1H",
      "reason": "some reason",
      "status": "APPROVED",
      "tender_id": "MtZRYYdDrYNQbOvV7nbuBvMF",
      "transaction_id": "KnL67ZIwXCPtzOrqj0HrkxMF"
    }
  ]
}
```

