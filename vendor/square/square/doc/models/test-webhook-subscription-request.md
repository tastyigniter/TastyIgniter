
# Test Webhook Subscription Request

Tests a [Subscription](../../doc/models/webhook-subscription.md) by sending a test event to its notification URL.

## Structure

`TestWebhookSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `eventType` | `?string` | Optional | The event type that will be used to test the [Subscription](entity:WebhookSubscription). The event type must be<br>contained in the list of event types in the [Subscription](entity:WebhookSubscription). | getEventType(): ?string | setEventType(?string eventType): void |

## Example (as JSON)

```json
{
  "event_type": "payment.created"
}
```

