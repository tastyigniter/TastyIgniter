
# Update Webhook Subscription Response

Defines the fields that are included in the response body of
a request to the [UpdateWebhookSubscription](../../doc/apis/webhook-subscriptions.md#update-webhook-subscription) endpoint.

Note: If there are errors processing the request, the [Subscription](../../doc/models/webhook-subscription.md) is not
present.

## Structure

`UpdateWebhookSubscriptionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscription` | [`?WebhookSubscription`](../../doc/models/webhook-subscription.md) | Optional | Represents the details of a webhook subscription, including notification URL,<br>event types, and signature key. | getSubscription(): ?WebhookSubscription | setSubscription(?WebhookSubscription subscription): void |

## Example (as JSON)

```json
{
  "subscription": {
    "api_version": "2021-12-15",
    "created_at": "2022-01-10 23:29:48 +0000 UTC",
    "enabled": false,
    "event_types": [
      "payment.created",
      "payment.updated"
    ],
    "id": "wbhk_b35f6b3145074cf9ad513610786c19d5",
    "name": "Updated Example Webhook Subscription",
    "notification_url": "https://example-webhook-url.com",
    "updated_at": "2022-01-10 23:45:51 +0000 UTC"
  }
}
```

