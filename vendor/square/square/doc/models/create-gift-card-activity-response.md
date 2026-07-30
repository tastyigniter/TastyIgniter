
# Create Gift Card Activity Response

A response that contains a `GiftCardActivity` that was created.
The response might contain a set of `Error` objects if the request resulted in errors.

## Structure

`CreateGiftCardActivityResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `giftCardActivity` | [`?GiftCardActivity`](../../doc/models/gift-card-activity.md) | Optional | Represents an action performed on a [gift card](../../doc/models/gift-card.md) that affects its state or balance.<br>A gift card activity contains information about a specific activity type. For example, a `REDEEM` activity<br>includes a `redeem_activity_details` field that contains information about the redemption. | getGiftCardActivity(): ?GiftCardActivity | setGiftCardActivity(?GiftCardActivity giftCardActivity): void |

## Example (as JSON)

```json
{
  "gift_card_activity": {
    "activate_activity_details": {
      "amount_money": {
        "amount": 1000,
        "currency": "USD"
      },
      "line_item_uid": "eIWl7X0nMuO9Ewbh0ChIx",
      "order_id": "jJNGHm4gLI6XkFbwtiSLqK72KkAZY"
    },
    "created_at": "2021-05-20T22:26:54.000Z",
    "gift_card_balance_money": {
      "amount": 1000,
      "currency": "USD"
    },
    "gift_card_gan": "7783320002929081",
    "gift_card_id": "gftc:6d55a72470d940c6ba09c0ab8ad08d20",
    "id": "gcact_c8f8cbf1f24b448d8ecf39ed03f97864",
    "location_id": "81FN9BNFZTKS4",
    "type": "ACTIVATE"
  }
}
```

