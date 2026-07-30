
# Search Orders Date Time Filter

Filter for `Order` objects based on whether their `CREATED_AT`,
`CLOSED_AT`, or `UPDATED_AT` timestamps fall within a specified time range.
You can specify the time range and which timestamp to filter for. You can filter
for only one time range at a time.

For each time range, the start time and end time are inclusive. If the end time
is absent, it defaults to the time of the first request for the cursor.

__Important:__ If you use the `DateTimeFilter` in a `SearchOrders` query,
you must set the `sort_field` in [OrdersSort](../../doc/models/search-orders-sort.md)
to the same field you filter for. For example, if you set the `CLOSED_AT` field
in `DateTimeFilter`, you must set the `sort_field` in `SearchOrdersSort` to
`CLOSED_AT`. Otherwise, `SearchOrders` throws an error.
[Learn more about filtering orders by time range.](https://developer.squareup.com/docs/orders-api/manage-orders/search-orders#important-note-about-filtering-orders-by-time-range)

## Structure

`SearchOrdersDateTimeFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `createdAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getCreatedAt(): ?TimeRange | setCreatedAt(?TimeRange createdAt): void |
| `updatedAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getUpdatedAt(): ?TimeRange | setUpdatedAt(?TimeRange updatedAt): void |
| `closedAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getClosedAt(): ?TimeRange | setClosedAt(?TimeRange closedAt): void |

## Example (as JSON)

```json
{
  "created_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  },
  "updated_at": {
    "start_at": "start_at6",
    "end_at": "end_at6"
  },
  "closed_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  }
}
```

