
# Subscription Event

Describes changes to a subscription and the subscription status.

## Structure

`SubscriptionEvent`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `string` | Required | The ID of the subscription event. | getId(): string | setId(string id): void |
| `subscriptionEventType` | [`string (SubscriptionEventSubscriptionEventType)`](../../doc/models/subscription-event-subscription-event-type.md) | Required | Supported types of an event occurred to a subscription. | getSubscriptionEventType(): string | setSubscriptionEventType(string subscriptionEventType): void |
| `effectiveDate` | `string` | Required | The `YYYY-MM-DD`-formatted date (for example, 2013-01-15) when the subscription event occurred. | getEffectiveDate(): string | setEffectiveDate(string effectiveDate): void |
| `planId` | `string` | Required | The ID of the subscription plan associated with the subscription. | getPlanId(): string | setPlanId(string planId): void |
| `info` | [`?SubscriptionEventInfo`](../../doc/models/subscription-event-info.md) | Optional | Provides information about the subscription event. | getInfo(): ?SubscriptionEventInfo | setInfo(?SubscriptionEventInfo info): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "subscription_event_type": "RESUME_SUBSCRIPTION",
  "effective_date": "effective_date0",
  "plan_id": "plan_id8",
  "info": {
    "detail": "detail6",
    "code": "CUSTOMER_DELETED"
  }
}
```

