
# Test Webhook Subscription Response

Defines the fields that are included in the response body of
a request to the [TestWebhookSubscription](../../doc/apis/webhook-subscriptions.md#test-webhook-subscription) endpoint.

Note: If there are errors processing the request, the [SubscriptionTestResult](../../doc/models/subscription-test-result.md) field is not
present.

## Structure

`TestWebhookSubscriptionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscriptionTestResult` | [`?SubscriptionTestResult`](../../doc/models/subscription-test-result.md) | Optional | Represents the details of a webhook subscription, including notification URL,<br>event types, and signature key. | getSubscriptionTestResult(): ?SubscriptionTestResult | setSubscriptionTestResult(?SubscriptionTestResult subscriptionTestResult): void |

## Example (as JSON)

```json
{
  "subscription_test_result": {
    "created_at": "2022-01-11 00:06:48.322945116 +0000 UTC m=+3863.054453746",
    "id": "23eed5a9-2b12-403e-b212-7e2889aea0f6",
    "payload": "{\"merchant_id\":\"1ZYMKZY1YFGBW\",\"type\":\"payment.created\",\"event_id\":\"23eed5a9-2b12-403e-b212-7e2889aea0f6\",\"created_at\":\"2022-01-11T00:06:48.322945116Z\",\"data\":{\"type\":\"payment\",\"id\":\"KkAkhdMsgzn59SM8A89WgKwekxLZY\",\"object\":{\"payment\":{\"amount_money\":{\"amount\":100,\"currency\":\"USD\"},\"approved_money\":{\"amount\":100,\"currency\":\"USD\"},\"capabilities\":[\"EDIT_TIP_AMOUNT\",\"EDIT_TIP_AMOUNT_UP\",\"EDIT_TIP_AMOUNT_DOWN\"],\"card_details\":{\"avs_status\":\"AVS_ACCEPTED\",\"card\":{\"bin\":\"540988\",\"card_brand\":\"MASTERCARD\",\"card_type\":\"CREDIT\",\"exp_month\":11,\"exp_year\":2022,\"fingerprint\":\"sq-1-Tvruf3vPQxlvI6n0IcKYfBukrcv6IqWr8UyBdViWXU2yzGn5VMJvrsHMKpINMhPmVg\",\"last_4\":\"9029\",\"prepaid_type\":\"NOT_PREPAID\"},\"card_payment_timeline\":{\"authorized_at\":\"2020-11-22T21:16:51.198Z\"},\"cvv_status\":\"CVV_ACCEPTED\",\"entry_method\":\"KEYED\",\"statement_description\":\"SQ *DEFAULT TEST ACCOUNT\",\"status\":\"AUTHORIZED\"},\"created_at\":\"2020-11-22T21:16:51.086Z\",\"delay_action\":\"CANCEL\",\"delay_duration\":\"PT168H\",\"delayed_until\":\"2020-11-29T21:16:51.086Z\",\"id\":\"hYy9pRFVxpDsO1FB05SunFWUe9JZY\",\"location_id\":\"S8GWD5R9QB376\",\"order_id\":\"03O3USaPaAaFnI6kkwB1JxGgBsUZY\",\"receipt_number\":\"hYy9\",\"risk_evaluation\":{\"created_at\":\"2020-11-22T21:16:51.198Z\",\"risk_level\":\"NORMAL\"},\"source_type\":\"CARD\",\"status\":\"APPROVED\",\"total_money\":{\"amount\":100,\"currency\":\"USD\"},\"updated_at\":\"2020-11-22T21:16:51.198Z\",\"version_token\":\"FfQhQJf9r3VSQIgyWBk1oqhIwiznLwVwJbVVA0bdyEv6o\"}}}}",
    "status_code": 404,
    "updated_at": "2022-01-11 00:06:48.322945116 +0000 UTC m=+3863.054453746"
  }
}
```

