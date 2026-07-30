
# Tender

Represents a tender (i.e., a method of payment) used in a Square transaction.

## Structure

`Tender`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The tender's unique ID. It is the associated payment ID.<br>**Constraints**: *Maximum Length*: `192` | getId(): ?string | setId(?string id): void |
| `locationId` | `?string` | Optional | The ID of the transaction's associated location.<br>**Constraints**: *Maximum Length*: `50` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `transactionId` | `?string` | Optional | The ID of the tender's associated transaction.<br>**Constraints**: *Maximum Length*: `192` | getTransactionId(): ?string | setTransactionId(?string transactionId): void |
| `createdAt` | `?string` | Optional | The timestamp for when the tender was created, in RFC 3339 format.<br>**Constraints**: *Maximum Length*: `32` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `note` | `?string` | Optional | An optional note associated with the tender at the time of payment.<br>**Constraints**: *Maximum Length*: `500` | getNote(): ?string | setNote(?string note): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `tipMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTipMoney(): ?Money | setTipMoney(?Money tipMoney): void |
| `processingFeeMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getProcessingFeeMoney(): ?Money | setProcessingFeeMoney(?Money processingFeeMoney): void |
| `customerId` | `?string` | Optional | If the tender is associated with a customer or represents a customer's card on file,<br>this is the ID of the associated customer.<br>**Constraints**: *Maximum Length*: `191` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `type` | [`string (TenderType)`](../../doc/models/tender-type.md) | Required | Indicates a tender's type. | getType(): string | setType(string type): void |
| `cardDetails` | [`?TenderCardDetails`](../../doc/models/tender-card-details.md) | Optional | Represents additional details of a tender with `type` `CARD` or `SQUARE_GIFT_CARD` | getCardDetails(): ?TenderCardDetails | setCardDetails(?TenderCardDetails cardDetails): void |
| `cashDetails` | [`?TenderCashDetails`](../../doc/models/tender-cash-details.md) | Optional | Represents the details of a tender with `type` `CASH`. | getCashDetails(): ?TenderCashDetails | setCashDetails(?TenderCashDetails cashDetails): void |
| `additionalRecipients` | [`?(AdditionalRecipient[])`](../../doc/models/additional-recipient.md) | Optional | Additional recipients (other than the merchant) receiving a portion of this tender.<br>For example, fees assessed on the purchase by a third party integration. | getAdditionalRecipients(): ?array | setAdditionalRecipients(?array additionalRecipients): void |
| `paymentId` | `?string` | Optional | The ID of the [Payment](entity:Payment) that corresponds to this tender.<br>This value is only present for payments created with the v2 Payments API.<br>**Constraints**: *Maximum Length*: `192` | getPaymentId(): ?string | setPaymentId(?string paymentId): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "location_id": "location_id4",
  "transaction_id": "transaction_id8",
  "created_at": "created_at2",
  "note": "note4",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "tip_money": {
    "amount": 190,
    "currency": "CHE"
  },
  "processing_fee_money": {
    "amount": 112,
    "currency": "XBB"
  },
  "customer_id": "customer_id8",
  "type": "WALLET",
  "card_details": {
    "status": "AUTHORIZED",
    "card": {
      "id": "id6",
      "card_brand": "JCB",
      "last_4": "last_48",
      "exp_month": 4,
      "exp_year": 36,
      "cardholder_name": "cardholder_name8",
      "billing_address": {
        "address_line_1": "address_line_12",
        "address_line_2": "address_line_28",
        "address_line_3": "address_line_34",
        "locality": "locality2",
        "sublocality": "sublocality8",
        "sublocality_2": "sublocality_26",
        "sublocality_3": "sublocality_32",
        "administrative_district_level_1": "administrative_district_level_12",
        "administrative_district_level_2": "administrative_district_level_26",
        "administrative_district_level_3": "administrative_district_level_36",
        "postal_code": "postal_code0",
        "country": "RW",
        "first_name": "first_name8",
        "last_name": "last_name6"
      },
      "fingerprint": "fingerprint2",
      "customer_id": "customer_id4",
      "merchant_id": "merchant_id6",
      "reference_id": "reference_id4",
      "enabled": false,
      "card_type": "UNKNOWN_CARD_TYPE",
      "prepaid_type": "PREPAID",
      "bin": "bin6",
      "version": 122,
      "card_co_brand": "AFTERPAY"
    },
    "entry_method": "ON_FILE"
  },
  "cash_details": {
    "buyer_tendered_money": {
      "amount": 8,
      "currency": "XXX"
    },
    "change_back_money": {
      "amount": 112,
      "currency": "BHD"
    }
  },
  "additional_recipients": [
    {
      "location_id": "location_id3",
      "description": "description9",
      "amount_money": {
        "amount": 83,
        "currency": "ALL"
      },
      "receivable_id": "receivable_id9"
    },
    {
      "location_id": "location_id4",
      "description": "description0",
      "amount_money": {
        "amount": 84,
        "currency": "AMD"
      },
      "receivable_id": "receivable_id0"
    },
    {
      "location_id": "location_id5",
      "description": "description1",
      "amount_money": {
        "amount": 85,
        "currency": "ANG"
      },
      "receivable_id": "receivable_id1"
    }
  ],
  "payment_id": "payment_id0"
}
```

