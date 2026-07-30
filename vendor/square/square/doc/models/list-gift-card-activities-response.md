
# List Gift Card Activities Response

A response that contains a list of `GiftCardActivity` objects. If the request resulted in errors,
the response contains a set of `Error` objects.

## Structure

`ListGiftCardActivitiesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `giftCardActivities` | [`?(GiftCardActivity[])`](../../doc/models/gift-card-activity.md) | Optional | The requested gift card activities or an empty object if none are found. | getGiftCardActivities(): ?array | setGiftCardActivities(?array giftCardActivities): void |
| `cursor` | `?string` | Optional | When a response is truncated, it includes a cursor that you can use in a<br>subsequent request to retrieve the next set of activities. If a cursor is not present, this is<br>the final response.<br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "gift_card_activities": [
    {
      "created_at": "2021-06-02T22:26:38.000Z",
      "gift_card_balance_money": {
        "amount": 700,
        "currency": "USD"
      },
      "gift_card_gan": "7783320002929081",
      "gift_card_id": "gftc:6d55a72470d940c6ba09c0ab8ad08d20",
      "id": "gcact_897698f894b44b3db46c6147e26a0e19",
      "location_id": "81FN9BNFZTKS4",
      "payment_id": "dEv2eksNPy6GqdYiLe4ZBNk6HqXZY",
      "redeem_activity_details": {
        "amount_money": {
          "amount": 300,
          "currency": "USD"
        }
      },
      "status": "COMPLETED",
      "type": "REDEEM"
    },
    {
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
      "id": "gcact_b968ebfc7d46437b945be7b9e09123b4",
      "location_id": "81FN9BNFZTKS4",
      "type": "ACTIVATE"
    }
  ]
}
```

