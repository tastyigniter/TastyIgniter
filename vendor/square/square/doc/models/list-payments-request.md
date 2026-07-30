
# List Payments Request

Describes a request to list payments using
[ListPayments](../../doc/apis/payments.md#list-payments).

The maximum results per page is 100.

## Structure

`ListPaymentsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `beginTime` | `?string` | Optional | Indicates the start of the time range to retrieve payments for, in RFC 3339 format.  <br>The range is determined using the `created_at` field for each Payment.<br>Inclusive. Default: The current time minus one year. | getBeginTime(): ?string | setBeginTime(?string beginTime): void |
| `endTime` | `?string` | Optional | Indicates the end of the time range to retrieve payments for, in RFC 3339 format.  The<br>range is determined using the `created_at` field for each Payment.<br><br>Default: The current time. | getEndTime(): ?string | setEndTime(?string endTime): void |
| `sortOrder` | `?string` | Optional | The order in which results are listed by `Payment.created_at`:<br><br>- `ASC` - Oldest to newest.<br>- `DESC` - Newest to oldest (default). | getSortOrder(): ?string | setSortOrder(?string sortOrder): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `locationId` | `?string` | Optional | Limit results to the location supplied. By default, results are returned<br>for the default (main) location associated with the seller. | getLocationId(): ?string | setLocationId(?string locationId): void |
| `total` | `?int` | Optional | The exact amount in the `total_money` for a payment. | getTotal(): ?int | setTotal(?int total): void |
| `last4` | `?string` | Optional | The last four digits of a payment card. | getLast4(): ?string | setLast4(?string last4): void |
| `cardBrand` | `?string` | Optional | The brand of the payment card (for example, VISA). | getCardBrand(): ?string | setCardBrand(?string cardBrand): void |
| `limit` | `?int` | Optional | The maximum number of results to be returned in a single page.<br>It is possible to receive fewer results than the specified limit on a given page.<br><br>The default value of 100 is also the maximum allowed value. If the provided value is<br>greater than 100, it is ignored and the default value is used instead.<br><br>Default: `100` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{}
```

