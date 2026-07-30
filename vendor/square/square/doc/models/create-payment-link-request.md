
# Create Payment Link Request

## Structure

`CreatePaymentLinkRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies this `CreatePaymentLinkRequest` request.<br>If you do not provide a unique string (or provide an empty string as the value),<br>the endpoint treats each request as independent.<br><br>For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-apis/idempotency).<br>**Constraints**: *Maximum Length*: `192` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `description` | `?string` | Optional | A description of the payment link. You provide this optional description that is useful in your<br>application context. It is not used anywhere.<br>**Constraints**: *Maximum Length*: `4096` | getDescription(): ?string | setDescription(?string description): void |
| `quickPay` | [`?QuickPay`](../../doc/models/quick-pay.md) | Optional | Describes an ad hoc item and price to generate a quick pay checkout link.<br>For more information,<br>see [Quick Pay Checkout](https://developer.squareup.com/docs/checkout-api/quick-pay-checkout). | getQuickPay(): ?QuickPay | setQuickPay(?QuickPay quickPay): void |
| `order` | [`?Order`](../../doc/models/order.md) | Optional | Contains all information related to a single order to process with Square,<br>including line items that specify the products to purchase. `Order` objects also<br>include information about any associated tenders, refunds, and returns.<br><br>All Connect V2 Transactions have all been converted to Orders including all associated<br>itemization data. | getOrder(): ?Order | setOrder(?Order order): void |
| `checkoutOptions` | [`?CheckoutOptions`](../../doc/models/checkout-options.md) | Optional | - | getCheckoutOptions(): ?CheckoutOptions | setCheckoutOptions(?CheckoutOptions checkoutOptions): void |
| `prePopulatedData` | [`?PrePopulatedData`](../../doc/models/pre-populated-data.md) | Optional | Describes buyer data to prepopulate in the payment form.<br>For more information,<br>see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-checkout-configurations). | getPrePopulatedData(): ?PrePopulatedData | setPrePopulatedData(?PrePopulatedData prePopulatedData): void |
| `paymentNote` | `?string` | Optional | A note for the payment. After processing the payment, Square adds this note to the resulting `Payment`.<br>**Constraints**: *Maximum Length*: `500` | getPaymentNote(): ?string | setPaymentNote(?string paymentNote): void |

## Example (as JSON)

```json
{
  "idempotency_key": "cd9e25dc-d9f2-4430-aedb-61605070e95f",
  "quick_pay": {
    "location_id": "A9Y43N9ABXZBP",
    "name": "Auto Detailing",
    "price_money": {
      "amount": 10000,
      "currency": "USD"
    }
  }
}
```

