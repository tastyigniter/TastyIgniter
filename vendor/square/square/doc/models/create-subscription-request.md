
# Create Subscription Request

Defines input parameters in a request to the
[CreateSubscription](../../doc/apis/subscriptions.md#create-subscription) endpoint.

## Structure

`CreateSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies this `CreateSubscription` request.<br>If you do not provide a unique string (or provide an empty string as the value),<br>the endpoint treats each request as independent.<br><br>For more information, see [Idempotency keys](https://developer.squareup.com/docs/working-with-apis/idempotency). | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `locationId` | `string` | Required | The ID of the location the subscription is associated with.<br>**Constraints**: *Minimum Length*: `1` | getLocationId(): string | setLocationId(string locationId): void |
| `planId` | `string` | Required | The ID of the subscription plan created using the Catalog API.<br>For more information, see<br>[Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-plan) and<br>[Subscriptions Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough).<br>**Constraints**: *Minimum Length*: `1` | getPlanId(): string | setPlanId(string planId): void |
| `customerId` | `string` | Required | The ID of the [customer](entity:Customer) subscribing to the subscription plan.<br>**Constraints**: *Minimum Length*: `1` | getCustomerId(): string | setCustomerId(string customerId): void |
| `startDate` | `?string` | Optional | The `YYYY-MM-DD`-formatted date to start the subscription.<br>If it is unspecified, the subscription starts immediately. | getStartDate(): ?string | setStartDate(?string startDate): void |
| `canceledDate` | `?string` | Optional | The `YYYY-MM-DD`-formatted date when the newly created subscription is scheduled for cancellation.<br><br>This date overrides the cancellation date set in the plan configuration.<br>If the cancellation date is earlier than the end date of a subscription cycle, the subscription stops<br>at the canceled date and the subscriber is sent a prorated invoice at the beginning of the canceled cycle.<br><br>When the subscription plan of the newly created subscription has a fixed number of cycles and the `canceled_date`<br>occurs before the subscription plan expires, the specified `canceled_date` sets the date when the subscription<br>stops through the end of the last cycle. | getCanceledDate(): ?string | setCanceledDate(?string canceledDate): void |
| `taxPercentage` | `?string` | Optional | The tax to add when billing the subscription.<br>The percentage is expressed in decimal form, using a `'.'` as the decimal<br>separator and without a `'%'` sign. For example, a value of 7.5<br>corresponds to 7.5%.<br>**Constraints**: *Maximum Length*: `10` | getTaxPercentage(): ?string | setTaxPercentage(?string taxPercentage): void |
| `priceOverrideMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getPriceOverrideMoney(): ?Money | setPriceOverrideMoney(?Money priceOverrideMoney): void |
| `cardId` | `?string` | Optional | The ID of the [subscriber's](entity:Customer) [card](entity:Card) to charge.<br>If it is not specified, the subscriber receives an invoice via email. For an example to<br>create a customer profile for a subscriber and add a card on file, see [Subscriptions Walkthrough](https://developer.squareup.com/docs/subscriptions-api/walkthrough). | getCardId(): ?string | setCardId(?string cardId): void |
| `timezone` | `?string` | Optional | The timezone that is used in date calculations for the subscription. If unset, defaults to<br>the location timezone. If a timezone is not configured for the location, defaults to "America/New_York".<br>Format: the IANA Timezone Database identifier for the location timezone. For<br>a list of time zones, see [List of tz database time zones](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones). | getTimezone(): ?string | setTimezone(?string timezone): void |
| `source` | [`?SubscriptionSource`](../../doc/models/subscription-source.md) | Optional | The origination details of the subscription. | getSource(): ?SubscriptionSource | setSource(?SubscriptionSource source): void |

## Example (as JSON)

```json
{
  "card_id": "ccof:qy5x8hHGYsgLrp4Q4GB",
  "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
  "idempotency_key": "8193148c-9586-11e6-99f9-28cfe92138cf",
  "location_id": "S8GWD5R9QB376",
  "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
  "price_override_money": {
    "amount": 100,
    "currency": "USD"
  },
  "source": {
    "name": "My App"
  },
  "start_date": "2021-10-20",
  "tax_percentage": "5",
  "timezone": "America/Los_Angeles"
}
```

