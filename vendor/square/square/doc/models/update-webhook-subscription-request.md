
# Update Webhook Subscription Request

Updates a [Subscription](../../doc/models/webhook-subscription.md).

## Structure

`UpdateWebhookSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `subscription` | [`?WebhookSubscription`](../../doc/models/webhook-subscription.md) | Optional | Represents the details of a webhook subscription, including notification URL,<br>event types, and signature key. | getSubscription(): ?WebhookSubscription | setSubscription(?WebhookSubscription subscription): void |

## Example (as JSON)

```json
{
  "subscription": {
    "enabled": false,
    "name": "Updated Example Webhook Subscription"
  }
}
```

