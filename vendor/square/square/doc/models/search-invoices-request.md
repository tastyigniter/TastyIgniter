
# Search Invoices Request

Describes a `SearchInvoices` request.

## Structure

`SearchInvoicesRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`InvoiceQuery`](../../doc/models/invoice-query.md) | Required | Describes query criteria for searching invoices. | getQuery(): InvoiceQuery | setQuery(InvoiceQuery query): void |
| `limit` | `?int` | Optional | The maximum number of invoices to return (200 is the maximum `limit`).<br>If not provided, the server uses a default limit of 100 invoices. | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for your original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "query": {
    "filter": {
      "customer_ids": [
        "JDKYHBWT1D4F8MFH63DBMEN8Y4"
      ],
      "location_ids": [
        "ES0RJRZYEC39A"
      ]
    },
    "limit": 100,
    "sort": {
      "field": "INVOICE_SORT_DATE",
      "order": "DESC"
    }
  }
}
```

