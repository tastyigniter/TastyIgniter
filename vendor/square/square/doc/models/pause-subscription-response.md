
# Pause Subscription Response

Defines output parameters in a response from the
[PauseSubscription](../../doc/apis/subscriptions.md#pause-subscription) endpoint.

## Structure

`PauseSubscriptionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscription` | [`?Subscription`](../../doc/models/subscription.md) | Optional | Represents a subscription to a subscription plan by a subscriber.<br><br>For an overview of the `Subscription` type, see<br>[Subscription object](https://developer.squareup.com/docs/subscriptions-api/overview#subscription-object-overview). | getSubscription(): ?Subscription | setSubscription(?Subscription subscription): void |
| `actions` | [`?(SubscriptionAction[])`](../../doc/models/subscription-action.md) | Optional | The list of a `PAUSE` action and a possible `RESUME` action created by the request. | getActions(): ?array | setActions(?array actions): void |

## Example (as JSON)

```json
{
  "actions": [
    {
      "effective_date": "2021-11-17",
      "id": "99b2439e-63f7-3ad5-95f7-ab2447a80673",
      "type": "PAUSE"
    }
  ],
  "subscription": {
    "created_at": "2021-10-20T21:53:10Z",
    "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
    "id": "9ba40961-995a-4a3d-8c53-048c40cafc13",
    "location_id": "S8GWD5R9QB376",
    "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
    "price_override_money": {
      "amount": 2000,
      "currency": "USD"
    },
    "source": {
      "name": "My App"
    },
    "status": "ACTIVE",
    "timezone": "America/Los_Angeles",
    "version": 1594311617331
  }
}
```

