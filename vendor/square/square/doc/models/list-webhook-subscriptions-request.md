
# List Webhook Subscriptions Request

Lists all [Subscription](../../doc/models/webhook-subscription.md)s owned by your application.

## Structure

`ListWebhookSubscriptionsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for your original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/basics/api101/pagination).<br>**Constraints**: *Maximum Length*: `256` | getCursor(): ?string | setCursor(?string cursor): void |
| `includeDisabled` | `?bool` | Optional | Includes disabled [Subscription](entity:WebhookSubscription)s.<br>By default, all enabled [Subscription](entity:WebhookSubscription)s are returned. | getIncludeDisabled(): ?bool | setIncludeDisabled(?bool includeDisabled): void |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |
| `limit` | `?int` | Optional | The maximum number of results to be returned in a single page.<br>It is possible to receive fewer results than the specified limit on a given page.<br>The default value of 100 is also the maximum allowed value.<br><br>Default: 100<br>**Constraints**: `>= 1`, `<= 100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "cursor": "cursor6",
  "include_disabled": false,
  "sort_order": "DESC",
  "limit": 172
}
```

