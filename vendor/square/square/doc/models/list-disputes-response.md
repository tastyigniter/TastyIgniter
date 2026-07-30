
# List Disputes Response

Defines fields in a `ListDisputes` response.

## Structure

`ListDisputesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `disputes` | [`?(Dispute[])`](../../doc/models/dispute.md) | Optional | The list of disputes. | getDisputes(): ?array | setDisputes(?array disputes): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request.<br>If unset, this is the final response. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "cursor": "G1aSTRm48CLjJsg6Sg3hQN1b1OMaoVuG",
  "disputes": [
    {
      "amount_money": {
        "amount": 2500,
        "currency": "USD"
      },
      "brand_dispute_id": "100000809947",
      "card_brand": "VISA",
      "created_at": "2022-06-29T18:45:22.265Z",
      "disputed_payment": {
        "payment_id": "zhyh1ch64kRBrrlfVhwjCEjZWzNZY"
      },
      "due_at": "2022-07-13T00:00:00.000Z",
      "id": "XDgyFu7yo1E2S5lQGGpYn",
      "location_id": "L1HN3ZMQK64X9",
      "reason": "NO_KNOWLEDGE",
      "reported_at": "2022-06-29T00:00:00.000Z",
      "state": "ACCEPTED",
      "updated_at": "2022-07-07T19:14:42.650Z",
      "version": 2
    },
    {
      "amount_money": {
        "amount": 2209,
        "currency": "USD"
      },
      "brand_dispute_id": "r5Of6YaGT7AdeRaVoAGCJw",
      "card_brand": "VISA",
      "created_at": "2022-04-29T18:45:22.265Z",
      "disputed_payment": {
        "payment_id": "zhyh1ch64kRBrrlfVhwjCEjZWzNZY"
      },
      "due_at": "2022-05-13T00:00:00.000Z",
      "id": "jLGg7aXC7lvKPr9PISt0T",
      "location_id": "18YC4JDH91E1H",
      "reason": "NOT_AS_DESCRIBED",
      "reported_at": "2022-04-29T00:00:00.000Z",
      "state": "EVIDENCE_REQUIRED",
      "updated_at": "2022-04-29T18:45:22.265Z",
      "version": 1
    }
  ]
}
```

