
# List Webhook Event Types Request

Lists all webhook event types that can be subscribed to.

## Structure

`ListWebhookEventTypesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `apiVersion` | `?string` | Optional | The API version for which to list event types. Setting this field overrides the default version used by the application. | getApiVersion(): ?string | setApiVersion(?string apiVersion): void |

## Example (as JSON)

```json
{
  "api_version": "api_version8"
}
```

