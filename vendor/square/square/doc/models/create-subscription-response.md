
# Create Subscription Response

Defines output parameters in a response from the
[CreateSubscription](../../doc/apis/subscriptions.md#create-subscription) endpoint.

## Structure

`CreateSubscriptionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscription` | [`?Subscription`](../../doc/models/subscription.md) | Optional | Represents a subscription to a subscription plan by a subscriber.<br><br>For an overview of the `Subscription` type, see<br>[Subscription object](https://developer.squareup.com/docs/subscriptions-api/overview#subscription-object-overview). | getSubscription(): ?Subscription | setSubscription(?Subscription subscription): void |

## Example (as JSON)

```json
{
  "subscription": {
    "card_id": "ccof:qy5x8hHGYsgLrp4Q4GB",
    "created_at": "2021-10-20T21:53:10Z",
    "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
    "id": "56214fb2-cc85-47a1-93bc-44f3766bb56f",
    "location_id": "S8GWD5R9QB376",
    "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
    "price_override_money": {
      "amount": 100,
      "currency": "USD"
    },
    "source": {
      "name": "My App"
    },
    "start_date": "2021-10-20",
    "status": "PENDING",
    "tax_percentage": "5",
    "timezone": "America/Los_Angeles",
    "version": 1594155459464
  }
}
```

