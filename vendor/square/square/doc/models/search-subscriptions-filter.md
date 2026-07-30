
# Search Subscriptions Filter

Represents a set of query expressions (filters) to narrow the scope of targeted subscriptions returned by
the [SearchSubscriptions](../../doc/apis/subscriptions.md#search-subscriptions) endpoint.

## Structure

`SearchSubscriptionsFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `customerIds` | `?(string[])` | Optional | A filter to select subscriptions based on the subscribing customer IDs. | getCustomerIds(): ?array | setCustomerIds(?array customerIds): void |
| `locationIds` | `?(string[])` | Optional | A filter to select subscriptions based on the location. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `sourceNames` | `?(string[])` | Optional | A filter to select subscriptions based on the source application. | getSourceNames(): ?array | setSourceNames(?array sourceNames): void |

## Example (as JSON)

```json
{
  "customer_ids": [
    "customer_ids1",
    "customer_ids2"
  ],
  "location_ids": [
    "location_ids0"
  ],
  "source_names": [
    "source_names8"
  ]
}
```

