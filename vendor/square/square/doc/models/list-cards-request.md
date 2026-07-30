
# List Cards Request

Retrieves details for a specific Card. Accessible via
HTTP requests at GET https://connect.squareup.com/v2/cards

## Structure

`ListCardsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for your original query.<br><br>See [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination) for more information.<br>**Constraints**: *Maximum Length*: `256` | getCursor(): ?string | setCursor(?string cursor): void |
| `customerId` | `?string` | Optional | Limit results to cards associated with the customer supplied.<br>By default, all cards owned by the merchant are returned. | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `includeDisabled` | `?bool` | Optional | Includes disabled cards.<br>By default, all enabled cards owned by the merchant are returned. | getIncludeDisabled(): ?bool | setIncludeDisabled(?bool includeDisabled): void |
| `referenceId` | `?string` | Optional | Limit results to cards associated with the reference_id supplied. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `sortOrder` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |

## Example (as JSON)

```json
{}
```

