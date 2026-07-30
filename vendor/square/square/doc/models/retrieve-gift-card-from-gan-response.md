
# Retrieve Gift Card From GAN Response

A response that contains a `GiftCard`. This response might contain a set of `Error` objects
if the request resulted in errors.

## Structure

`RetrieveGiftCardFromGANResponse`

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
      "amount": 5000,
      "currency": "USD"
    },
    "created_at": "2021-05-20T22:26:54.000Z",
    "gan": "7783320001001635",
    "gan_source": "SQUARE",
    "id": "gftc:6944163553804e439d89adb47caf806a",
    "state": "ACTIVE",
    "type": "DIGITAL"
  }
}
```

