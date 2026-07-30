
# V1 Order

V1Order

## Structure

`V1Order`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `id` | `?string` | Optional | The order's unique identifier. | getId(): ?string | setId(?string id): void |
| `buyerEmail` | `?string` | Optional | The email address of the order's buyer. | getBuyerEmail(): ?string | setBuyerEmail(?string buyerEmail): void |
| `recipientName` | `?string` | Optional | The name of the order's buyer. | getRecipientName(): ?string | setRecipientName(?string recipientName): void |
| `recipientPhoneNumber` | `?string` | Optional | The phone number to use for the order's delivery. | getRecipientPhoneNumber(): ?string | setRecipientPhoneNumber(?string recipientPhoneNumber): void |
| `state` | [`?string (V1OrderState)`](../../doc/models/v1-order-state.md) | Optional | - | getState(): ?string | setState(?string state): void |
| `shippingAddress` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getShippingAddress(): ?Address | setShippingAddress(?Address shippingAddress): void |
| `subtotalMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getSubtotalMoney(): ?V1Money | setSubtotalMoney(?V1Money subtotalMoney): void |
| `totalShippingMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalShippingMoney(): ?V1Money | setTotalShippingMoney(?V1Money totalShippingMoney): void |
| `totalTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalTaxMoney(): ?V1Money | setTotalTaxMoney(?V1Money totalTaxMoney): void |
| `totalPriceMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalPriceMoney(): ?V1Money | setTotalPriceMoney(?V1Money totalPriceMoney): void |
| `totalDiscountMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalDiscountMoney(): ?V1Money | setTotalDiscountMoney(?V1Money totalDiscountMoney): void |
| `createdAt` | `?string` | Optional | The time when the order was created, in ISO 8601 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The time when the order was last modified, in ISO 8601 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `expiresAt` | `?string` | Optional | The time when the order expires if no action is taken, in ISO 8601 format. | getExpiresAt(): ?string | setExpiresAt(?string expiresAt): void |
| `paymentId` | `?string` | Optional | The unique identifier of the payment associated with the order. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `buyerNote` | `?string` | Optional | A note provided by the buyer when the order was created, if any. | getBuyerNote(): ?string | setBuyerNote(?string buyerNote): void |
| `completedNote` | `?string` | Optional | A note provided by the merchant when the order's state was set to COMPLETED, if any | getCompletedNote(): ?string | setCompletedNote(?string completedNote): void |
| `refundedNote` | `?string` | Optional | A note provided by the merchant when the order's state was set to REFUNDED, if any. | getRefundedNote(): ?string | setRefundedNote(?string refundedNote): void |
| `canceledNote` | `?string` | Optional | A note provided by the merchant when the order's state was set to CANCELED, if any. | getCanceledNote(): ?string | setCanceledNote(?string canceledNote): void |
| `tender` | [`?V1Tender`](../../doc/models/v1-tender.md) | Optional | A tender represents a discrete monetary exchange. Square represents this<br>exchange as a money object with a specific currency and amount, where the<br>amount is given in the smallest denomination of the given currency.<br><br>Square POS can accept more than one form of tender for a single payment (such<br>as by splitting a bill between a credit card and a gift card). The `tender`<br>field of the Payment object lists all forms of tender used for the payment.<br><br>Split tender payments behave slightly differently from single tender payments:<br><br>The receipt_url for a split tender corresponds only to the first tender listed<br>in the tender field. To get the receipt URLs for the remaining tenders, use<br>the receipt_url fields of the corresponding Tender objects.<br><br>*A note on gift cards**: when a customer purchases a Square gift card from a<br>merchant, the merchant receives the full amount of the gift card in the<br>associated payment.<br><br>When that gift card is used as a tender, the balance of the gift card is<br>reduced and the merchant receives no funds. A `Tender` object with a type of<br>`SQUARE_GIFT_CARD` indicates a gift card was used for some or all of the<br>associated payment. | getTender(): ?V1Tender | setTender(?V1Tender tender): void |
| `orderHistory` | [`?(V1OrderHistoryEntry[])`](../../doc/models/v1-order-history-entry.md) | Optional | The history of actions associated with the order. | getOrderHistory(): ?array | setOrderHistory(?array orderHistory): void |
| `promoCode` | `?string` | Optional | The promo code provided by the buyer, if any. | getPromoCode(): ?string | setPromoCode(?string promoCode): void |
| `btcReceiveAddress` | `?string` | Optional | For Bitcoin transactions, the address that the buyer sent Bitcoin to. | getBtcReceiveAddress(): ?string | setBtcReceiveAddress(?string btcReceiveAddress): void |
| `btcPriceSatoshi` | `?float` | Optional | For Bitcoin transactions, the price of the buyer's order in satoshi (100 million satoshi equals 1 BTC). | getBtcPriceSatoshi(): ?float | setBtcPriceSatoshi(?float btcPriceSatoshi): void |

## Example (as JSON)

```json
{
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ],
  "id": "id0",
  "buyer_email": "buyer_email8",
  "recipient_name": "recipient_name8",
  "recipient_phone_number": "recipient_phone_number4",
  "state": "COMPLETED",
  "shipping_address": {
    "address_line_1": "address_line_10",
    "address_line_2": "address_line_20",
    "address_line_3": "address_line_36",
    "locality": "locality0",
    "sublocality": "sublocality0",
    "sublocality_2": "sublocality_28",
    "sublocality_3": "sublocality_30",
    "administrative_district_level_1": "administrative_district_level_14",
    "administrative_district_level_2": "administrative_district_level_26",
    "administrative_district_level_3": "administrative_district_level_38",
    "postal_code": "postal_code2",
    "country": "PT",
    "first_name": "first_name0",
    "last_name": "last_name8"
  },
  "subtotal_money": {
    "amount": 116,
    "currency_code": "JOD"
  },
  "total_shipping_money": {
    "amount": 118,
    "currency_code": "BOB"
  },
  "total_tax_money": {
    "amount": 58,
    "currency_code": "MVR"
  },
  "total_price_money": {
    "amount": 52,
    "currency_code": "KHR"
  },
  "total_discount_money": {
    "amount": 132,
    "currency_code": "PKR"
  },
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "expires_at": "expires_at6",
  "payment_id": "payment_id0",
  "buyer_note": "buyer_note2",
  "completed_note": "completed_note0",
  "refunded_note": "refunded_note4",
  "canceled_note": "canceled_note0",
  "tender": {
    "id": "id6",
    "type": "THIRD_PARTY_CARD",
    "name": "name6",
    "employee_id": "employee_id6",
    "receipt_url": "receipt_url2",
    "card_brand": "OTHER_BRAND",
    "pan_suffix": "pan_suffix6",
    "entry_method": "SWIPED",
    "payment_note": "payment_note4",
    "total_money": {
      "amount": 14,
      "currency_code": "SRD"
    },
    "tendered_money": {
      "amount": 122,
      "currency_code": "XAG"
    },
    "tendered_at": "tendered_at0",
    "settled_at": "settled_at8",
    "change_back_money": {},
    "refunded_money": {},
    "is_exchange": false
  },
  "order_history": [
    {
      "action": "PAYMENT_RECEIVED",
      "created_at": "created_at5"
    }
  ],
  "promo_code": "promo_code2",
  "btc_receive_address": "btc_receive_address2",
  "btc_price_satoshi": 144.84
}
```

