
# Update Subscription Request

Defines input parameters in a request to the
[UpdateSubscription](../../doc/apis/subscriptions.md#update-subscription) endpoint.

## Structure

`UpdateSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `subscription` | [`?Subscription`](../../doc/models/subscription.md) | Optional | Represents a subscription to a subscription plan by a subscriber.<br><br>For an overview of the `Subscription` type, see<br>[Subscription object](https://developer.squareup.com/docs/subscriptions-api/overview#subscription-object-overview). | getSubscription(): ?Subscription | setSubscription(?Subscription subscription): void |

## Example (as JSON)

```json
{
  "subscription": {
    "price_override_money": {
      "amount": 2000,
      "currency": "USD"
    },
    "tax_percentage": null,
    "version": 1594155459464
  }
}
```

