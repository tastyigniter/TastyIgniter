
# List Subscription Events Response

Defines output parameters in a response from the
[ListSubscriptionEvents](../../doc/apis/subscriptions.md#list-subscription-events).

## Structure

`ListSubscriptionEventsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscriptionEvents` | [`?(SubscriptionEvent[])`](../../doc/models/subscription-event.md) | Optional | The retrieved subscription events. | getSubscriptionEvents(): ?array | setSubscriptionEvents(?array subscriptionEvents): void |
| `cursor` | `?string` | Optional | When the total number of resulting subscription events exceeds the limit of a paged response,<br>the response includes a cursor for you to use in a subsequent request to fetch the next set of events.<br>If the cursor is unset, the response contains the last page of the results.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "subscription_events": [
    {
      "effective_date": "2020-04-24",
      "id": "06809161-3867-4598-8269-8aea5be4f9de",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "START_SUBSCRIPTION"
    },
    {
      "effective_date": "2020-05-01",
      "id": "f2736603-cd2e-47ec-8675-f815fff54f88",
      "info": {
        "code": "CUSTOMER_NO_NAME",
        "detail": "The customer with ID `V74BMG0GPS2KNCWJE1BTYJ37Y0` does not have a name on record."
      },
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "DEACTIVATE_SUBSCRIPTION"
    },
    {
      "effective_date": "2022-05-01",
      "id": "b426fc85-6859-450b-b0d0-fe3a5d1b565f",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "RESUME_SUBSCRIPTION"
    },
    {
      "effective_date": "2022-05-02",
      "id": "09f14de1-2f53-4dae-9091-49aa53f83d01",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "PAUSE_SUBSCRIPTION"
    },
    {
      "effective_date": "2020-05-02",
      "id": "f28a73ac-1a1b-4b0f-8eeb-709a72945776",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "RESUME_SUBSCRIPTION"
    },
    {
      "effective_date": "2020-05-06",
      "id": "a0c08083-5db0-4800-85c7-d398de4fbb6e",
      "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
      "subscription_event_type": "STOP_SUBSCRIPTION"
    }
  ]
}
```

