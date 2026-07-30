
# Payment Link

## Structure

`PaymentLink`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The Square-assigned ID of the payment link. | getId(): ?string | setId(?string id): void |
| `version` | `int` | Required | The Square-assigned version number, which is incremented each time an update is committed to the payment link.<br>**Constraints**: `<= 65535` | getVersion(): int | setVersion(int version): void |
| `description` | `?string` | Optional | The optional description of the `payment_link` object.<br>It is primarily for use by your application and is not used anywhere.<br>**Constraints**: *Maximum Length*: `4096` | getDescription(): ?string | setDescription(?string description): void |
| `orderId` | `?string` | Optional | The ID of the order associated with the payment link.<br>**Constraints**: *Maximum Length*: `192` | getOrderId(): ?string | setOrderId(?string orderId): void |
| `checkoutOptions` | [`?CheckoutOptions`](../../doc/models/checkout-options.md) | Optional | - | getCheckoutOptions(): ?CheckoutOptions | setCheckoutOptions(?CheckoutOptions checkoutOptions): void |
| `prePopulatedData` | [`?PrePopulatedData`](../../doc/models/pre-populated-data.md) | Optional | Describes buyer data to prepopulate in the payment form.<br>For more information,<br>see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-checkout-configurations). | getPrePopulatedData(): ?PrePopulatedData | setPrePopulatedData(?PrePopulatedData prePopulatedData): void |
| `url` | `?string` | Optional | The shortened URL of the payment link.<br>**Constraints**: *Maximum Length*: `255` | getUrl(): ?string | setUrl(?string url): void |
| `longUrl` | `?string` | Optional | The long URL of the payment link.<br>**Constraints**: *Maximum Length*: `255` | getLongUrl(): ?string | setLongUrl(?string longUrl): void |
| `createdAt` | `?string` | Optional | The timestamp when the payment link was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp when the payment link was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `paymentNote` | `?string` | Optional | An optional note. After Square processes the payment, this note is added to the<br>resulting `Payment`.<br>**Constraints**: *Maximum Length*: `500` | getPaymentNote(): ?string | setPaymentNote(?string paymentNote): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "version": 172,
  "description": "description0",
  "order_id": "order_id6",
  "checkout_options": {
    "allow_tipping": false,
    "custom_fields": [
      {
        "title": "title9"
      },
      {
        "title": "title0"
      }
    ],
    "subscription_plan_id": "subscription_plan_id8",
    "redirect_url": "redirect_url2",
    "merchant_support_email": "merchant_support_email8",
    "ask_for_shipping_address": false,
    "accepted_payment_methods": {
      "apple_pay": false,
      "google_pay": false,
      "cash_app_pay": false,
      "afterpay_clearpay": false
    },
    "app_fee_money": {
      "amount": 194,
      "currency": "XBA"
    },
    "shipping_fee": {
      "name": "name2",
      "charge": {
        "amount": 8,
        "currency": "FJD"
      }
    }
  },
  "pre_populated_data": {
    "buyer_email": "buyer_email8",
    "buyer_phone_number": "buyer_phone_number0",
    "buyer_address": {
      "address_line_1": "address_line_12",
      "address_line_2": "address_line_22",
      "address_line_3": "address_line_38",
      "locality": "locality2",
      "sublocality": "sublocality2",
      "sublocality_2": "sublocality_20",
      "sublocality_3": "sublocality_32",
      "administrative_district_level_1": "administrative_district_level_16",
      "administrative_district_level_2": "administrative_district_level_28",
      "administrative_district_level_3": "administrative_district_level_30",
      "postal_code": "postal_code4",
      "country": "IO",
      "first_name": "first_name2",
      "last_name": "last_name0"
    }
  },
  "url": "url4",
  "long_url": "long_url0",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "payment_note": "payment_note8"
}
```

