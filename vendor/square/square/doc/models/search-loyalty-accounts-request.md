
# Search Loyalty Accounts Request

A request to search for loyalty accounts.

## Structure

`SearchLoyaltyAccountsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`?SearchLoyaltyAccountsRequestLoyaltyAccountQuery`](../../doc/models/search-loyalty-accounts-request-loyalty-account-query.md) | Optional | The search criteria for the loyalty accounts. | getQuery(): ?SearchLoyaltyAccountsRequestLoyaltyAccountQuery | setQuery(?SearchLoyaltyAccountsRequestLoyaltyAccountQuery query): void |
| `limit` | `?int` | Optional | The maximum number of results to include in the response. The default value is 30.<br>**Constraints**: `>= 1`, `<= 200` | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to<br>this endpoint. Provide this to retrieve the next set of<br>results for the original query.<br><br>For more information,<br>see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "limit": 10,
  "query": {
    "mappings": [
      {
        "phone_number": "+14155551234"
      }
    ]
  }
}
```

