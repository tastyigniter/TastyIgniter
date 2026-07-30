
# Payment Options

## Structure

`PaymentOptions`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `autocomplete` | `?bool` | Optional | Indicates whether the `Payment` objects created from this `TerminalCheckout` are automatically<br>`COMPLETED` or left in an `APPROVED` state for later modification. | getAutocomplete(): ?bool | setAutocomplete(?bool autocomplete): void |
| `delayDuration` | `?string` | Optional | The duration of time after the payment's creation when Square automatically cancels the<br>payment. This automatic cancellation applies only to payments that do not reach a terminal state<br>(COMPLETED or CANCELED) before the `delay_duration` time period.<br><br>This parameter should be specified as a time duration, in RFC 3339 format, with a minimum value<br>of 1 minute.<br><br>Note: This feature is only supported for card payments. This parameter can only be set for a delayed<br>capture payment (`autocomplete=false`).<br>Default:<br><br>- Card-present payments: "PT36H" (36 hours) from the creation time.<br>- Card-not-present payments: "P7D" (7 days) from the creation time. | getDelayDuration(): ?string | setDelayDuration(?string delayDuration): void |
| `acceptPartialAuthorization` | `?bool` | Optional | If set to `true` and charging a Square Gift Card, a payment might be returned with<br>`amount_money` equal to less than what was requested. For example, a request for $20 when charging<br>a Square Gift Card with a balance of $5 results in an APPROVED payment of $5. You might choose<br>to prompt the buyer for an additional payment to cover the remainder or cancel the Gift Card<br>payment.<br><br>This field cannot be `true` when `autocomplete = true`.<br>This field cannot be `true` when an `order_id` isn't specified.<br><br>For more information, see<br>[Take Partial Payments](https://developer.squareup.com/docs/payments-api/take-payments/card-payments/partial-payments-with-gift-cards).<br><br>Default: false | getAcceptPartialAuthorization(): ?bool | setAcceptPartialAuthorization(?bool acceptPartialAuthorization): void |
| `delayAction` | [`?string (PaymentOptionsDelayAction)`](../../doc/models/payment-options-delay-action.md) | Optional | Describes the action to be applied to a delayed capture payment when the delay_duration<br>has elapsed. | getDelayAction(): ?string | setDelayAction(?string delayAction): void |

## Example (as JSON)

```json
{
  "autocomplete": false,
  "delay_duration": "delay_duration2",
  "accept_partial_authorization": false,
  "delay_action": "CANCEL"
}
```

