
# Link Customer to Gift Card Response

A response that contains the linked `GiftCard` object. If the request resulted in errors,
the response contains a set of `Error` objects.

## Structure

`LinkCustomerToGiftCardResponse`

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
      "amount": 2500,
      "currency": "USD"
    },
    "created_at": "2021-03-25T05:13:01Z",
    "customer_ids": [
      "GKY0FZ3V717AH8Q2D821PNT2ZW"
    ],
    "gan": "7783320005440920",
    "gan_source": "SQUARE",
    "id": "gftc:71ea002277a34f8a945e284b04822edb",
    "state": "ACTIVE",
    "type": "DIGITAL"
  }
}
```

