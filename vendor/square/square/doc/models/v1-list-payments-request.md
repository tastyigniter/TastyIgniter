
# V1 List Payments Request

## Structure

`V1ListPaymentsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |
| `beginTime` | `?string` | Optional | The beginning of the requested reporting period, in ISO 8601 format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time minus one year. | getBeginTime(): ?string | setBeginTime(?string beginTime): void |
| `endTime` | `?string` | Optional | The end of the requested reporting period, in ISO 8601 format. If this value is more than one year greater than begin_time, this endpoint returns an error. Default value: The current time. | getEndTime(): ?string | setEndTime(?string endTime): void |
| `limit` | `?int` | Optional | The maximum number of payments to return in a single response. This value cannot exceed 200. | getLimit(): ?int | setLimit(?int limit): void |
| `batchToken` | `?string` | Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. | getBatchToken(): ?string | setBatchToken(?string batchToken): void |
| `includePartial` | `?bool` | Optional | Indicates whether or not to include partial payments in the response. Partial payments will have the tenders collected so far, but the itemizations will be empty until the payment is completed. | getIncludePartial(): ?bool | setIncludePartial(?bool includePartial): void |

## Example (as JSON)

```json
{
  "order": "DESC",
  "begin_time": "begin_time2",
  "end_time": "end_time2",
  "limit": 172,
  "batch_token": "batch_token2",
  "include_partial": false
}
```

