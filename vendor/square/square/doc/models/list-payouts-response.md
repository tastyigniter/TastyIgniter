
# List Payouts Response

The response to retrieve payout records entries.

## Structure

`ListPayoutsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `payouts` | [`?(Payout[])`](../../doc/models/payout.md) | Optional | The requested list of payouts. | getPayouts(): ?array | setPayouts(?array payouts): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request. If empty, this is the final response.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "cursor": "EMPCyStibo64hS8wLayZPp3oedR3AeEUNd3z7u6zphi72LQZFIEMbkKVvot9eefpU",
  "payouts": [
    {
      "amount_money": {
        "amount": 6259,
        "currency_code": "USD"
      },
      "arrival_date": "2022-03-29",
      "created_at": "2022-03-29T16:12:31Z",
      "destination": {
        "id": "ccof:ZPp3oedR3AeEUNd3z7",
        "type": "CARD"
      },
      "id": "po_b345d2c7-90b3-4f0b-a2aa-df1def7f8afc",
      "location_id": "L88917AVBK2S5",
      "payout_fee": [
        {
          "amount_money": {
            "amount": 95,
            "currency_code": "USD"
          },
          "effective_at": "2022-03-29T16:12:31Z",
          "type": "TRANSFER_FEE"
        }
      ],
      "status": "PAID",
      "type": "BATCH",
      "updated_at": "2022-03-30T01:07:22.875Z",
      "version": 2
    },
    {
      "amount_money": {
        "amount": -103,
        "currency_code": "USD"
      },
      "arrival_date": "2022-03-24",
      "created_at": "2022-03-24T03:07:09Z",
      "destination": {
        "id": "bact:ZPp3oedR3AeEUNd3z7",
        "type": "BANK_ACCOUNT"
      },
      "id": "po_f3c0fb38-a5ce-427d-b858-52b925b72e45",
      "location_id": "L88917AVBK2S5",
      "status": "PAID",
      "type": "BATCH",
      "updated_at": "2022-03-24T03:07:09Z",
      "version": 1
    }
  ]
}
```

