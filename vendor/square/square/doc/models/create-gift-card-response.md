
# Create Gift Card Response

A response that contains a `GiftCard`. The response might contain a set of `Error` objects if the request
resulted in errors.

## Structure

`CreateGiftCardResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `giftCard` | [`?GiftCard`](../../doc/models/gift-card.md) | Optional | Represents a Square gift card. | getGiftCard(): ?GiftCard | setGiftCard(?GiftCard giftCard): void |

## Example (as JSON)

```json
{
  "gift_card": {
    "balance_money": {
      "amount": 0,
      "currency": "USD"
    },
    "created_at": "2021-05-20T22:26:54.000Z",
    "gan": "7783320006753271",
    "gan_source": "SQUARE",
    "id": "gftc:6cbacbb64cf54e2ca9f573d619038059",
    "state": "PENDING",
    "type": "DIGITAL"
  }
}
```

