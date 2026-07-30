
# List Webhook Event Types Response

Defines the fields that are included in the response body of
a request to the [ListWebhookEventTypes](../../doc/apis/webhook-subscriptions.md#list-webhook-event-types) endpoint.

Note: if there are errors processing the request, the event types field will not be
present.

## Structure

`ListWebhookEventTypesResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `eventTypes` | `?(string[])` | Optional | The list of event types. | getEventTypes(): ?array | setEventTypes(?array eventTypes): void |
| `metadata` | [`?(EventTypeMetadata[])`](../../doc/models/event-type-metadata.md) | Optional | Contains the metadata of a webhook event type. For more information, see [EventTypeMetadata](entity:EventTypeMetadata). | getMetadata(): ?array | setMetadata(?array metadata): void |

## Example (as JSON)

```json
{
  "event_types": [
    "inventory.count.updated"
  ],
  "metadata": [
    {
      "api_version_introduced": "2018-07-12",
      "event_type": "inventory.count.updated",
      "release_status": "PUBLIC"
    }
  ]
}
```

