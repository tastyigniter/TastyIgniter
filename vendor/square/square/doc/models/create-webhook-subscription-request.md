
# Create Webhook Subscription Request

Creates a [Subscription](../../doc/models/webhook-subscription.md).

## Structure

`CreateWebhookSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies the [CreateWebhookSubscription](api-endpoint:WebhookSubscriptions-CreateWebhookSubscription) request.<br>**Constraints**: *Maximum Length*: `45` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `subscription` | [`WebhookSubscription`](../../doc/models/webhook-subscription.md) | Required | Represents the details of a webhook subscription, including notification URL,<br>event types, and signature key. | getSubscription(): WebhookSubscription | setSubscription(WebhookSubscription subscription): void |

## Example (as JSON)

```json
{
  "idempotency_key": "63f84c6c-2200-4c99-846c-2670a1311fbf",
  "subscription": {
    "api_version": "2021-12-15",
    "event_types": [
      "payment.created",
      "payment.updated"
    ],
    "name": "Example Webhook Subscription",
    "notification_url": "https://example-webhook-url.com"
  }
}
```

