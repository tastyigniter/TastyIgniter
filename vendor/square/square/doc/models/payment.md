
# Payment

Represents a payment processed by the Square API.

## Structure

`Payment`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | A unique ID for the payment.<br>**Constraints**: *Maximum Length*: `192` | getId(): ?string | setId(?string id): void |
| `createdAt` | `?string` | Optional | The timestamp of when the payment was created, in RFC 3339 format.<br>**Constraints**: *Maximum Length*: `32` | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp of when the payment was last updated, in RFC 3339 format.<br>**Constraints**: *Maximum Length*: `32` | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `tipMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTipMoney(): ?Money | setTipMoney(?Money tipMoney): void |
| `totalMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalMoney(): ?Money | setTotalMoney(?Money totalMoney): void |
| `appFeeMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppFeeMoney(): ?Money | setAppFeeMoney(?Money appFeeMoney): void |
| `approvedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getApprovedMoney(): ?Money | setApprovedMoney(?Money approvedMoney): void |
| `processingFee` | [`?(ProcessingFee[])`](../../doc/models/processing-fee.md) | Optional | The processing fees and fee adjustments assessed by Square for this payment. | getProcessingFee(): ?array | setProcessingFee(?array processingFee): void |
| `refundedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getRefundedMoney(): ?Money | setRefundedMoney(?Money refundedMoney): void |
| `status` | `?string` | Optional | Indicates whether the payment is APPROVED, PENDING, COMPLETED, CANCELED, or FAILED.<br>**Constraints**: *Maximum Length*: `50` | getStatus(): ?string | setStatus(?string status): void |
| `delayDuration` | `?string` | Optional | The duration of time after the payment's creation when Square automatically applies the<br>`delay_action` to the payment. This automatic `delay_action` applies only to payments that<br>do not reach a terminal state (COMPLETED, CANCELED, or FAILED) before the `delay_duration`<br>time period.<br><br>This field is specified as a time duration, in RFC 3339 format.<br><br>Notes:<br>This feature is only supported for card payments.<br><br>Default:<br><br>- Card-present payments: "PT36H" (36 hours) from the creation time.<br>- Card-not-present payments: "P7D" (7 days) from the creation time. | getDelayDuration(): ?string | setDelayDuration(?string delayDuration): void |
| `delayAction` | `?string` | Optional | The action to be applied to the payment when the `delay_duration` has elapsed.<br><br>Current values include `CANCEL` and `COMPLETE`. | getDelayAction(): ?string | setDelayAction(?string delayAction): void |
| `delayedUntil` | `?string` | Optional | The read-only timestamp of when the `delay_action` is automatically applied,<br>in RFC 3339 format.<br><br>Note that this field is calculated by summing the payment's `delay_duration` and `created_at`<br>fields. The `created_at` field is generated by Square and might not exactly match the<br>time on your local machine. | getDelayedUntil(): ?string | setDelayedUntil(?string delayedUntil): void |
| `sourceType` | `?string` | Optional | The source type for this payment.<br><br>Current values include `CARD`, `BANK_ACCOUNT`, `WALLET`, `BUY_NOW_PAY_LATER`, `CASH`<br>and `EXTERNAL`. For information about these payment source types,<br>see [Take Payments](https://developer.squareup.com/docs/payments-api/take-payments).<br>**Constraints**: *Maximum Length*: `50` | getSourceType(): ?string | setSourceType(?string sourceType): void |
| `cardDetails` | [`?CardPaymentDetails`](../../doc/models/card-payment-details.md) | Optional | Reflects the current status of a card payment. Contains only non-confidential information. | getCardDetails(): ?CardPaymentDetails | setCardDetails(?CardPaymentDetails cardDetails): void |
| `cashDetails` | [`?CashPaymentDetails`](../../doc/models/cash-payment-details.md) | Optional | Stores details about a cash payment. Contains only non-confidential information. For more information, see<br>[Take Cash Payments](https://developer.squareup.com/docs/payments-api/take-payments/cash-payments). | getCashDetails(): ?CashPaymentDetails | setCashDetails(?CashPaymentDetails cashDetails): void |
| `bankAccountDetails` | [`?BankAccountPaymentDetails`](../../doc/models/bank-account-payment-details.md) | Optional | Additional details about BANK_ACCOUNT type payments. | getBankAccountDetails(): ?BankAccountPaymentDetails | setBankAccountDetails(?BankAccountPaymentDetails bankAccountDetails): void |
| `externalDetails` | [`?ExternalPaymentDetails`](../../doc/models/external-payment-details.md) | Optional | Stores details about an external payment. Contains only non-confidential information.<br>For more information, see<br>[Take External Payments](https://developer.squareup.com/docs/payments-api/take-payments/external-payments). | getExternalDetails(): ?ExternalPaymentDetails | setExternalDetails(?ExternalPaymentDetails externalDetails): void |
| `walletDetails` | [`?DigitalWalletDetails`](../../doc/models/digital-wallet-details.md) | Optional | Additional details about `WALLET` type payments. Contains only non-confidential information. | getWalletDetails(): ?DigitalWalletDetails | setWalletDetails(?DigitalWalletDetails walletDetails): void |
| `buyNowPayLaterDetails` | [`?BuyNowPayLaterDetails`](../../doc/models/buy-now-pay-later-details.md) | Optional | Additional details about a Buy Now Pay Later payment type. | getBuyNowPayLaterDetails(): ?BuyNowPayLaterDetails | setBuyNowPayLaterDetails(?BuyNowPayLaterDetails buyNowPayLaterDetails): void |
| `locationId` | `?string` | Optional | The ID of the location associated with the payment.<br>**Constraints**: *Maximum Length*: `50` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `orderId` | `?string` | Optional | The ID of the order associated with the payment.<br>**Constraints**: *Maximum Length*: `192` | getOrderId(): ?string | setOrderId(?string orderId): void |
| `referenceId` | `?string` | Optional | An optional ID that associates the payment with an entity in<br>another system.<br>**Constraints**: *Maximum Length*: `40` | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `customerId` | `?string` | Optional | The ID of the customer associated with the payment. If the ID is<br>not provided in the `CreatePayment` request that was used to create the `Payment`,<br>Square may use information in the request<br>(such as the billing and shipping address, email address, and payment source)<br>to identify a matching customer profile in the Customer Directory.<br>If found, the profile ID is used. If a profile is not found, the<br>API attempts to create an<br>[instant profile](https://developer.squareup.com/docs/customers-api/what-it-does#instant-profiles).<br>If the API cannot create an<br>instant profile (either because the seller has disabled it or the<br>seller's region prevents creating it), this field remains unset. Note that<br>this process is asynchronous and it may take some time before a<br>customer ID is added to the payment.<br>**Constraints**: *Maximum Length*: `191` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `employeeId` | `?string` | Optional | __Deprecated__: Use `Payment.team_member_id` instead.<br><br>An optional ID of the employee associated with taking the payment.<br>**Constraints**: *Maximum Length*: `192` | getEmployeeId(): ?string | setEmployeeId(?string employeeId): void |
| `teamMemberId` | `?string` | Optional | An optional ID of the [TeamMember](entity:TeamMember) associated with taking the payment.<br>**Constraints**: *Maximum Length*: `192` | getTeamMemberId(): ?string | setTeamMemberId(?string teamMemberId): void |
| `refundIds` | `?(string[])` | Optional | A list of `refund_id`s identifying refunds for the payment. | getRefundIds(): ?array | setRefundIds(?array refundIds): void |
| `riskEvaluation` | [`?RiskEvaluation`](../../doc/models/risk-evaluation.md) | Optional | Represents fraud risk information for the associated payment.<br><br>When you take a payment through Square's Payments API (using the `CreatePayment`<br>endpoint), Square evaluates it and assigns a risk level to the payment. Sellers<br>can use this information to determine the course of action (for example,<br>provide the goods/services or refund the payment). | getRiskEvaluation(): ?RiskEvaluation | setRiskEvaluation(?RiskEvaluation riskEvaluation): void |
| `buyerEmailAddress` | `?string` | Optional | The buyer's email address.<br>**Constraints**: *Maximum Length*: `255` | getBuyerEmailAddress(): ?string | setBuyerEmailAddress(?string buyerEmailAddress): void |
| `billingAddress` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getBillingAddress(): ?Address | setBillingAddress(?Address billingAddress): void |
| `shippingAddress` | [`?Address`](../../doc/models/address.md) | Optional | Represents a postal address in a country.<br>For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-basics/working-with-addresses). | getShippingAddress(): ?Address | setShippingAddress(?Address shippingAddress): void |
| `note` | `?string` | Optional | An optional note to include when creating a payment.<br>**Constraints**: *Maximum Length*: `500` | getNote(): ?string | setNote(?string note): void |
| `statementDescriptionIdentifier` | `?string` | Optional | Additional payment information that gets added to the customer's card statement<br>as part of the statement description.<br><br>Note that the `statement_description_identifier` might get truncated on the statement description<br>to fit the required information including the Square identifier (SQ *) and the name of the<br>seller taking the payment. | getStatementDescriptionIdentifier(): ?string | setStatementDescriptionIdentifier(?string statementDescriptionIdentifier): void |
| `capabilities` | `?(string[])` | Optional | Actions that can be performed on this payment:<br><br>- `EDIT_AMOUNT_UP` - The payment amount can be edited up.<br>- `EDIT_AMOUNT_DOWN` - The payment amount can be edited down.<br>- `EDIT_TIP_AMOUNT_UP` - The tip amount can be edited up.<br>- `EDIT_TIP_AMOUNT_DOWN` - The tip amount can be edited down.<br>- `EDIT_DELAY_ACTION` - The delay_action can be edited. | getCapabilities(): ?array | setCapabilities(?array capabilities): void |
| `receiptNumber` | `?string` | Optional | The payment's receipt number.<br>The field is missing if a payment is canceled.<br>**Constraints**: *Maximum Length*: `4` | getReceiptNumber(): ?string | setReceiptNumber(?string receiptNumber): void |
| `receiptUrl` | `?string` | Optional | The URL for the payment's receipt.<br>The field is only populated for COMPLETED payments.<br>**Constraints**: *Maximum Length*: `255` | getReceiptUrl(): ?string | setReceiptUrl(?string receiptUrl): void |
| `deviceDetails` | [`?DeviceDetails`](../../doc/models/device-details.md) | Optional | Details about the device that took the payment. | getDeviceDetails(): ?DeviceDetails | setDeviceDetails(?DeviceDetails deviceDetails): void |
| `applicationDetails` | [`?ApplicationDetails`](../../doc/models/application-details.md) | Optional | Details about the application that took the payment. | getApplicationDetails(): ?ApplicationDetails | setApplicationDetails(?ApplicationDetails applicationDetails): void |
| `versionToken` | `?string` | Optional | Used for optimistic concurrency. This opaque token identifies a specific version of the<br>`Payment` object. | getVersionToken(): ?string | setVersionToken(?string versionToken): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "tip_money": {
    "amount": 190,
    "currency": "CHE"
  },
  "total_money": {
    "amount": 250,
    "currency": "UNKNOWN_CURRENCY"
  },
  "app_fee_money": {
    "amount": 106,
    "currency": "GBP"
  },
  "approved_money": {
    "amount": 138,
    "currency": "GIP"
  },
  "processing_fee": [
    {
      "effective_at": "effective_at6",
      "type": "type8",
      "amount_money": {
        "amount": 214,
        "currency": "BWP"
      }
    },
    {
      "effective_at": "effective_at7",
      "type": "type7",
      "amount_money": {
        "amount": 215,
        "currency": "BYR"
      }
    },
    {
      "effective_at": "effective_at8",
      "type": "type6",
      "amount_money": {
        "amount": 216,
        "currency": "BZD"
      }
    }
  ],
  "refunded_money": {
    "amount": 214,
    "currency": "GYD"
  },
  "status": "status8",
  "delay_duration": "delay_duration2",
  "delay_action": "delay_action0",
  "delayed_until": "delayed_until2",
  "source_type": "source_type0",
  "card_details": {
    "status": "status4",
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
    "entry_method": "entry_method8",
    "cvv_status": "cvv_status4",
    "avs_status": "avs_status6",
    "auth_result_code": "auth_result_code0",
    "application_identifier": "application_identifier4",
    "application_name": "application_name6",
    "application_cryptogram": "application_cryptogram6",
    "verification_method": "verification_method2",
    "verification_results": "verification_results4",
    "statement_description": "statement_description6",
    "device_details": {
      "device_id": "device_id2",
      "device_installation_id": "device_installation_id4",
      "device_name": "device_name6"
    },
    "card_payment_timeline": {
      "authorized_at": "authorized_at8",
      "captured_at": "captured_at8",
      "voided_at": "voided_at2"
    },
    "refund_requires_card_presence": false,
    "errors": [
      {
        "category": "INVALID_REQUEST_ERROR",
        "code": "INVALID_EMAIL_ADDRESS",
        "detail": "detail3",
        "field": "field1"
      }
    ]
  },
  "cash_details": {
    "buyer_supplied_money": {
      "amount": 140,
      "currency": "MYR"
    },
    "change_back_money": {
      "amount": 112,
      "currency": "BHD"
    }
  },
  "bank_account_details": {
    "bank_name": "bank_name4",
    "transfer_type": "transfer_type8",
    "account_ownership_type": "account_ownership_type8",
    "fingerprint": "fingerprint6",
    "country": "country4",
    "statement_description": "statement_description4",
    "ach_details": {
      "routing_number": "routing_number0",
      "account_number_suffix": "account_number_suffix8",
      "account_type": "account_type2"
    },
    "errors": [
      {
        "category": "API_ERROR",
        "code": "V1_APPLICATION",
        "detail": "detail1",
        "field": "field9"
      },
      {
        "category": "AUTHENTICATION_ERROR",
        "code": "V1_ACCESS_TOKEN",
        "detail": "detail2",
        "field": "field0"
      }
    ]
  },
  "external_details": {
    "type": "type6",
    "source": "source0",
    "source_id": "source_id8",
    "source_fee_money": {
      "amount": 234,
      "currency": "NZD"
    }
  },
  "wallet_details": {
    "status": "status2",
    "brand": "brand0",
    "cash_app_details": {
      "buyer_full_name": "buyer_full_name4",
      "buyer_country_code": "buyer_country_code4",
      "buyer_cashtag": "buyer_cashtag2"
    }
  },
  "buy_now_pay_later_details": {
    "brand": "brand4",
    "afterpay_details": {
      "email_address": "email_address2"
    },
    "clearpay_details": {
      "email_address": "email_address4"
    }
  },
  "location_id": "location_id4",
  "order_id": "order_id6",
  "reference_id": "reference_id2",
  "customer_id": "customer_id8",
  "employee_id": "employee_id0",
  "team_member_id": "team_member_id0",
  "refund_ids": [
    "refund_ids9"
  ],
  "risk_evaluation": {
    "created_at": "created_at0",
    "risk_level": "PENDING"
  },
  "buyer_email_address": "buyer_email_address8",
  "billing_address": {
    "address_line_1": "address_line_12",
    "address_line_2": "address_line_28",
    "address_line_3": "address_line_34",
    "locality": "locality8",
    "sublocality": "sublocality8",
    "sublocality_2": "sublocality_26",
    "sublocality_3": "sublocality_38",
    "administrative_district_level_1": "administrative_district_level_12",
    "administrative_district_level_2": "administrative_district_level_26",
    "administrative_district_level_3": "administrative_district_level_36",
    "postal_code": "postal_code0",
    "country": "MG",
    "first_name": "first_name8",
    "last_name": "last_name6"
  },
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
  "note": "note4",
  "statement_description_identifier": "statement_description_identifier4",
  "capabilities": [
    "capabilities7"
  ],
  "receipt_number": "receipt_number4",
  "receipt_url": "receipt_url8",
  "device_details": {
    "device_id": "device_id2",
    "device_installation_id": "device_installation_id4",
    "device_name": "device_name6"
  },
  "application_details": {
    "square_product": "RETAIL",
    "application_id": "application_id6"
  },
  "version_token": "version_token4"
}
```

