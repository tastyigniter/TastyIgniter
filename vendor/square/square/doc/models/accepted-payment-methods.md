
# Accepted Payment Methods

## Structure

`AcceptedPaymentMethods`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `applePay` | `?bool` | Optional | Whether Apple Pay is accepted at checkout. | getApplePay(): ?bool | setApplePay(?bool applePay): void |
| `googlePay` | `?bool` | Optional | Whether Google Pay is accepted at checkout. | getGooglePay(): ?bool | setGooglePay(?bool googlePay): void |
| `cashAppPay` | `?bool` | Optional | Whether Cash App Pay is accepted at checkout. | getCashAppPay(): ?bool | setCashAppPay(?bool cashAppPay): void |
| `afterpayClearpay` | `?bool` | Optional | Whether Afterpay/Clearpay is accepted at checkout. | getAfterpayClearpay(): ?bool | setAfterpayClearpay(?bool afterpayClearpay): void |

## Example (as JSON)

```json
{
  "apple_pay": false,
  "google_pay": false,
  "cash_app_pay": false,
  "afterpay_clearpay": false
}
```

