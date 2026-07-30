
# V1 List Refunds Request

## Structure

`V1ListRefundsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `order` | [`?string (SortOrder)`](../../doc/models/sort-order.md) | Optional | The order (e.g., chronological or alphabetical) in which results from a request are returned. | getOrder(): ?string | setOrder(?string order): void |
| `beginTime` | `?string` | Optional | The beginning of the requested reporting period, in ISO 8601 format. If this value is before January 1, 2013 (2013-01-01T00:00:00Z), this endpoint returns an error. Default value: The current time minus one year. | getBeginTime(): ?string | setBeginTime(?string beginTime): void |
| `endTime` | `?string` | Optional | The end of the requested reporting period, in ISO 8601 format. If this value is more than one year greater than begin_time, this endpoint returns an error. Default value: The current time. | getEndTime(): ?string | setEndTime(?string endTime): void |
| `limit` | `?int` | Optional | The approximate number of refunds to return in a single response. Default: 100. Max: 200. Response may contain more results than the prescribed limit when refunds are made simultaneously to multiple tenders in a payment or when refunds are generated in an exchange to account for the value of returned goods. | getLimit(): ?int | setLimit(?int limit): void |
| `batchToken` | `?string` | Optional | A pagination cursor to retrieve the next set of results for your<br>original query to the endpoint. | getBatchToken(): ?string | setBatchToken(?string batchToken): void |

## Example (as JSON)

```json
{
  "order": "DESC",
  "begin_time": "begin_time2",
  "end_time": "end_time2",
  "limit": 172,
  "batch_token": "batch_token2"
}
```

