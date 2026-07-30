
# Search Subscriptions Response

Defines output parameters in a response from the
[SearchSubscriptions](../../doc/apis/subscriptions.md#search-subscriptions) endpoint.

## Structure

`SearchSubscriptionsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscriptions` | [`?(Subscription[])`](../../doc/models/subscription.md) | Optional | The subscriptions matching the specified query expressions. | getSubscriptions(): ?array | setSubscriptions(?array subscriptions): void |
| `cursor` | `?string` | Optional | When the total number of resulting subscription exceeds the limit of a paged response,<br>the response includes a cursor for you to use in a subsequent request to fetch the next set of results.<br>If the cursor is unset, the response contains the last page of the results.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "subscriptions": [
    {
      "canceled_date": "2021-10-20",
      "card_id": "ccof:mueUsvgajChmjEbp4GB",
      "charged_through_date": "2021-11-20",
      "created_at": "2021-10-20T21:53:10Z",
      "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
      "id": "de86fc96-8664-474b-af1a-abbe59cacf0e",
      "location_id": "S8GWD5R9QB376",
      "paid_until_date": "2021-11-20",
      "plan_id": "L3TJVDHVBEQEGQDEZL2JJM7R",
      "source": {
        "name": "My Application"
      },
      "start_date": "2021-10-20",
      "status": "CANCELED",
      "timezone": "UTC"
    },
    {
      "created_at": "2021-10-20T21:53:10Z",
      "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
      "id": "56214fb2-cc85-47a1-93bc-44f3766bb56f",
      "location_id": "S8GWD5R9QB376",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "price_override_money": {
        "amount": 100,
        "currency": "USD"
      },
      "source": {
        "name": "My Application"
      },
      "start_date": "2021-10-20",
      "status": "PENDING",
      "tax_percentage": "5",
      "timezone": "America/Los_Angeles",
      "version": 1594155459464
    },
    {
      "charged_through_date": "2021-11-20",
      "created_at": "2021-10-20T21:53:10Z",
      "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
      "id": "8151fc89-da15-4eb9-a685-1a70883cebfc",
      "invoice_ids": [
        "grebK0Q_l8H4fqoMMVvt-Q",
        "rcX_i3sNmHTGKhI4W2mceA"
      ],
      "location_id": "S8GWD5R9QB376",
      "paid_until_date": "2021-11-20",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "price_override_money": {
        "amount": 1000,
        "currency": "USD"
      },
      "source": {
        "name": "My Application"
      },
      "start_date": "2021-10-20",
      "status": "ACTIVE",
      "timezone": "America/Los_Angeles"
    }
  ]
}
```

