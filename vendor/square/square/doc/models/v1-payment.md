
# V1 Payment

A payment represents a paid transaction between a Square merchant and a
customer. Payment details are usually available from Connect API endpoints
within a few minutes after the transaction completes.

Each Payment object includes several fields that end in `_money`. These fields
describe the various amounts of money that contribute to the payment total:

<ul>
<li>
Monetary values are <b>positive</b> if they represent an
<em>increase</em> in the amount of money the merchant receives (e.g.,
<code>tax_money</code>, <code>tip_money</code>).
</li>
<li>
Monetary values are <b>negative</b> if they represent an
<em>decrease</em> in the amount of money the merchant receives (e.g.,
<code>discount_money</code>, <code>refunded_money</code>).
</li>
</ul>


## Structure

`V1Payment`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The payment's unique identifier. | getId(): ?string | setId(?string id): void |
| `merchantId` | `?string` | Optional | The unique identifier of the merchant that took the payment. | getMerchantId(): ?string | setMerchantId(?string merchantId): void |
| `createdAt` | `?string` | Optional | The time when the payment was created, in ISO 8601 format. Reflects the time of the first payment if the object represents an incomplete partial payment, and the time of the last or complete payment otherwise. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `creatorId` | `?string` | Optional | The unique identifier of the Square account that took the payment. | getCreatorId(): ?string | setCreatorId(?string creatorId): void |
| `device` | [`?Device`](../../doc/models/device.md) | Optional | - | getDevice(): ?Device | setDevice(?Device device): void |
| `paymentUrl` | `?string` | Optional | The URL of the payment's detail page in the merchant dashboard. The merchant must be signed in to the merchant dashboard to view this page. | getPaymentUrl(): ?string | setPaymentUrl(?string paymentUrl): void |
| `receiptUrl` | `?string` | Optional | The URL of the receipt for the payment. Note that for split tender<br>payments, this URL corresponds to the receipt for the first tender<br>listed in the payment's tender field. Each Tender object has its own<br>receipt_url field you can use to get the other receipts associated with<br>a split tender payment. | getReceiptUrl(): ?string | setReceiptUrl(?string receiptUrl): void |
| `inclusiveTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getInclusiveTaxMoney(): ?V1Money | setInclusiveTaxMoney(?V1Money inclusiveTaxMoney): void |
| `additiveTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getAdditiveTaxMoney(): ?V1Money | setAdditiveTaxMoney(?V1Money additiveTaxMoney): void |
| `taxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTaxMoney(): ?V1Money | setTaxMoney(?V1Money taxMoney): void |
| `tipMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTipMoney(): ?V1Money | setTipMoney(?V1Money tipMoney): void |
| `discountMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getDiscountMoney(): ?V1Money | setDiscountMoney(?V1Money discountMoney): void |
| `totalCollectedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalCollectedMoney(): ?V1Money | setTotalCollectedMoney(?V1Money totalCollectedMoney): void |
| `processingFeeMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getProcessingFeeMoney(): ?V1Money | setProcessingFeeMoney(?V1Money processingFeeMoney): void |
| `netTotalMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getNetTotalMoney(): ?V1Money | setNetTotalMoney(?V1Money netTotalMoney): void |
| `refundedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedMoney(): ?V1Money | setRefundedMoney(?V1Money refundedMoney): void |
| `swedishRoundingMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getSwedishRoundingMoney(): ?V1Money | setSwedishRoundingMoney(?V1Money swedishRoundingMoney): void |
| `grossSalesMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getGrossSalesMoney(): ?V1Money | setGrossSalesMoney(?V1Money grossSalesMoney): void |
| `netSalesMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getNetSalesMoney(): ?V1Money | setNetSalesMoney(?V1Money netSalesMoney): void |
| `inclusiveTax` | [`?(V1PaymentTax[])`](../../doc/models/v1-payment-tax.md) | Optional | All of the inclusive taxes associated with the payment. | getInclusiveTax(): ?array | setInclusiveTax(?array inclusiveTax): void |
| `additiveTax` | [`?(V1PaymentTax[])`](../../doc/models/v1-payment-tax.md) | Optional | All of the additive taxes associated with the payment. | getAdditiveTax(): ?array | setAdditiveTax(?array additiveTax): void |
| `tender` | [`?(V1Tender[])`](../../doc/models/v1-tender.md) | Optional | All of the tenders associated with the payment. | getTender(): ?array | setTender(?array tender): void |
| `refunds` | [`?(V1Refund[])`](../../doc/models/v1-refund.md) | Optional | All of the refunds applied to the payment. Note that the value of all refunds on a payment can exceed the value of all tenders if a merchant chooses to refund money to a tender after previously accepting returned goods as part of an exchange. | getRefunds(): ?array | setRefunds(?array refunds): void |
| `itemizations` | [`?(V1PaymentItemization[])`](../../doc/models/v1-payment-itemization.md) | Optional | The items purchased in the payment. | getItemizations(): ?array | setItemizations(?array itemizations): void |
| `surchargeMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getSurchargeMoney(): ?V1Money | setSurchargeMoney(?V1Money surchargeMoney): void |
| `surcharges` | [`?(V1PaymentSurcharge[])`](../../doc/models/v1-payment-surcharge.md) | Optional | A list of all surcharges associated with the payment. | getSurcharges(): ?array | setSurcharges(?array surcharges): void |
| `isPartial` | `?bool` | Optional | Indicates whether or not the payment is only partially paid for.<br>If true, this payment will have the tenders collected so far, but the<br>itemizations will be empty until the payment is completed. | getIsPartial(): ?bool | setIsPartial(?bool isPartial): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "merchant_id": "merchant_id0",
  "created_at": "created_at2",
  "creator_id": "creator_id0",
  "device": {
    "id": "id6",
    "name": "name6"
  },
  "payment_url": "payment_url6",
  "receipt_url": "receipt_url8",
  "inclusive_tax_money": {
    "amount": 240,
    "currency_code": "TZS"
  },
  "additive_tax_money": {
    "amount": 16,
    "currency_code": "AMD"
  },
  "tax_money": {
    "amount": 58,
    "currency_code": "GHS"
  },
  "tip_money": {
    "amount": 190,
    "currency_code": "AED"
  },
  "discount_money": {
    "amount": 92,
    "currency_code": "DJF"
  },
  "total_collected_money": {
    "amount": 236,
    "currency_code": "CVE"
  },
  "processing_fee_money": {
    "amount": 112,
    "currency_code": "SVC"
  },
  "net_total_money": {
    "amount": 208,
    "currency_code": "INR"
  },
  "refunded_money": {
    "amount": 214,
    "currency_code": "CHW"
  },
  "swedish_rounding_money": {
    "amount": 114,
    "currency_code": "CUC"
  },
  "gross_sales_money": {
    "amount": 198,
    "currency_code": "HKD"
  },
  "net_sales_money": {
    "amount": 110,
    "currency_code": "UZS"
  },
  "inclusive_tax": [
    {
      "errors": [
        {
          "category": "AUTHENTICATION_ERROR",
          "code": "FORBIDDEN",
          "detail": "detail8",
          "field": "field6"
        },
        {
          "category": "INVALID_REQUEST_ERROR",
          "code": "INSUFFICIENT_SCOPES",
          "detail": "detail9",
          "field": "field7"
        },
        {
          "category": "RATE_LIMIT_ERROR",
          "code": "APPLICATION_DISABLED",
          "detail": "detail0",
          "field": "field8"
        }
      ],
      "name": "name7",
      "applied_money": {
        "amount": 39,
        "currency_code": "XBB"
      },
      "rate": "rate3",
      "inclusion_type": "INCLUSIVE",
      "fee_id": "fee_id5"
    },
    {
      "errors": [
        {
          "category": "INVALID_REQUEST_ERROR",
          "code": "INSUFFICIENT_SCOPES",
          "detail": "detail9",
          "field": "field7"
        }
      ],
      "name": "name8",
      "applied_money": {
        "amount": 38,
        "currency_code": "XBA"
      },
      "rate": "rate2",
      "inclusion_type": "ADDITIVE",
      "fee_id": "fee_id6"
    }
  ],
  "additive_tax": [
    {
      "errors": [
        {
          "category": "PAYMENT_METHOD_ERROR",
          "code": "INVALID_PHONE_NUMBER",
          "detail": "detail4",
          "field": "field2"
        },
        {
          "category": "REFUND_ERROR",
          "code": "CHECKOUT_EXPIRED",
          "detail": "detail5",
          "field": "field3"
        },
        {
          "category": "MERCHANT_SUBSCRIPTION_ERROR",
          "code": "BAD_CERTIFICATE",
          "detail": "detail6",
          "field": "field4"
        }
      ],
      "name": "name3",
      "applied_money": {
        "amount": 179,
        "currency_code": "COU"
      },
      "rate": "rate3",
      "inclusion_type": "INCLUSIVE",
      "fee_id": "fee_id1"
    },
    {
      "errors": [
        {
          "category": "REFUND_ERROR",
          "code": "CHECKOUT_EXPIRED",
          "detail": "detail5",
          "field": "field3"
        }
      ],
      "name": "name4",
      "applied_money": {
        "amount": 180,
        "currency_code": "CRC"
      },
      "rate": "rate4",
      "inclusion_type": "ADDITIVE",
      "fee_id": "fee_id2"
    }
  ],
  "tender": [
    {
      "id": "id4",
      "type": "CREDIT_CARD",
      "name": "name4",
      "employee_id": "employee_id4",
      "receipt_url": "receipt_url6",
      "card_brand": "OTHER_BRAND",
      "pan_suffix": "pan_suffix4",
      "entry_method": "SQUARE_WALLET",
      "payment_note": "payment_note2",
      "total_money": {
        "amount": 24,
        "currency_code": "CNY"
      },
      "tendered_money": {
        "amount": 132,
        "currency_code": "HRK"
      },
      "tendered_at": "tendered_at8",
      "settled_at": "settled_at0",
      "change_back_money": {},
      "refunded_money": {},
      "is_exchange": false
    }
  ],
  "refunds": [
    {
      "type": "FULL",
      "reason": "reason0",
      "refunded_money": {
        "amount": 214,
        "currency_code": "MVR"
      },
      "refunded_processing_fee_money": {
        "amount": 92,
        "currency_code": "HNL"
      },
      "refunded_tax_money": {},
      "refunded_additive_tax_money": {},
      "refunded_additive_tax": [
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "EXPECTED_ARRAY",
              "detail": "detail5",
              "field": "field3"
            }
          ],
          "name": "name4",
          "applied_money": {},
          "rate": "rate6",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id2"
        },
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "EXPECTED_MAP",
              "detail": "detail6",
              "field": "field4"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "EXPECTED_BASE64_ENCODED_BYTE_ARRAY",
              "detail": "detail7",
              "field": "field5"
            }
          ],
          "name": "name5",
          "applied_money": {},
          "rate": "rate5",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id3"
        }
      ],
      "refunded_inclusive_tax_money": {},
      "refunded_inclusive_tax": [
        {},
        {}
      ],
      "refunded_tip_money": {},
      "refunded_discount_money": {},
      "refunded_surcharge_money": {},
      "refunded_surcharges": [
        {
          "name": "name0",
          "applied_money": {},
          "rate": "rate0",
          "amount_money": {},
          "type": "AUTO_GRATUITY",
          "taxable": false,
          "taxes": [
            {}
          ],
          "surcharge_id": "surcharge_id4"
        },
        {
          "name": "name9",
          "applied_money": {},
          "rate": "rate1",
          "amount_money": {},
          "type": "CUSTOM",
          "taxable": true,
          "taxes": [
            {},
            {}
          ],
          "surcharge_id": "surcharge_id5"
        },
        {
          "name": "name8",
          "applied_money": {},
          "rate": "rate2",
          "amount_money": {},
          "type": "UNKNOWN",
          "taxable": false,
          "taxes": [
            {},
            {},
            {}
          ],
          "surcharge_id": "surcharge_id6"
        }
      ],
      "created_at": "created_at2",
      "processed_at": "processed_at2",
      "payment_id": "payment_id4",
      "merchant_id": "merchant_id4",
      "is_exchange": false
    },
    {
      "type": "PARTIAL",
      "reason": "reason9",
      "refunded_money": {
        "amount": 215,
        "currency_code": "MWK"
      },
      "refunded_processing_fee_money": {
        "amount": 91,
        "currency_code": "HKD"
      },
      "refunded_tax_money": {},
      "refunded_additive_tax_money": {},
      "refunded_additive_tax": [
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "EXPECTED_MAP",
              "detail": "detail6",
              "field": "field4"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "EXPECTED_BASE64_ENCODED_BYTE_ARRAY",
              "detail": "detail7",
              "field": "field5"
            }
          ],
          "name": "name5",
          "applied_money": {},
          "rate": "rate5",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id3"
        },
        {
          "errors": [
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "EXPECTED_BASE64_ENCODED_BYTE_ARRAY",
              "detail": "detail7",
              "field": "field5"
            },
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "INVALID_ARRAY_VALUE",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "RATE_LIMIT_ERROR",
              "code": "INVALID_ENUM_VALUE",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name6",
          "applied_money": {},
          "rate": "rate4",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id4"
        },
        {
          "errors": [
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "INVALID_ARRAY_VALUE",
              "detail": "detail8",
              "field": "field6"
            }
          ],
          "name": "name7",
          "applied_money": {},
          "rate": "rate3",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id5"
        }
      ],
      "refunded_inclusive_tax_money": {},
      "refunded_inclusive_tax": [
        {},
        {},
        {}
      ],
      "refunded_tip_money": {},
      "refunded_discount_money": {},
      "refunded_surcharge_money": {},
      "refunded_surcharges": [
        {
          "name": "name1",
          "applied_money": {},
          "rate": "rate9",
          "amount_money": {},
          "type": "UNKNOWN",
          "taxable": true,
          "taxes": [
            {},
            {},
            {}
          ],
          "surcharge_id": "surcharge_id3"
        },
        {
          "name": "name0",
          "applied_money": {},
          "rate": "rate0",
          "amount_money": {},
          "type": "AUTO_GRATUITY",
          "taxable": false,
          "taxes": [
            {}
          ],
          "surcharge_id": "surcharge_id4"
        }
      ],
      "created_at": "created_at3",
      "processed_at": "processed_at1",
      "payment_id": "payment_id5",
      "merchant_id": "merchant_id5",
      "is_exchange": true
    },
    {
      "type": "FULL",
      "reason": "reason8",
      "refunded_money": {
        "amount": 216,
        "currency_code": "MXN"
      },
      "refunded_processing_fee_money": {
        "amount": 90,
        "currency_code": "GYD"
      },
      "refunded_tax_money": {},
      "refunded_additive_tax_money": {},
      "refunded_additive_tax": [
        {
          "errors": [
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "EXPECTED_BASE64_ENCODED_BYTE_ARRAY",
              "detail": "detail7",
              "field": "field5"
            },
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "INVALID_ARRAY_VALUE",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "RATE_LIMIT_ERROR",
              "code": "INVALID_ENUM_VALUE",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name6",
          "applied_money": {},
          "rate": "rate4",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id4"
        }
      ],
      "refunded_inclusive_tax_money": {},
      "refunded_inclusive_tax": [
        {}
      ],
      "refunded_tip_money": {},
      "refunded_discount_money": {},
      "refunded_surcharge_money": {},
      "refunded_surcharges": [
        {
          "name": "name2",
          "applied_money": {},
          "rate": "rate8",
          "amount_money": {},
          "type": "CUSTOM",
          "taxable": false,
          "taxes": [
            {},
            {}
          ],
          "surcharge_id": "surcharge_id2"
        }
      ],
      "created_at": "created_at4",
      "processed_at": "processed_at0",
      "payment_id": "payment_id6",
      "merchant_id": "merchant_id6",
      "is_exchange": false
    }
  ],
  "itemizations": [
    {
      "name": "name6",
      "quantity": 167.22,
      "itemization_type": "GIFT_CARD_UNKNOWN",
      "item_detail": {
        "category_name": "category_name4",
        "sku": "sku0",
        "item_id": "item_id6",
        "item_variation_id": "item_variation_id8"
      },
      "notes": "notes6",
      "item_variation_name": "item_variation_name6",
      "total_money": {
        "amount": 8,
        "currency_code": "UAH"
      },
      "single_quantity_money": {
        "amount": 170,
        "currency_code": "USN"
      },
      "gross_sales_money": {},
      "discount_money": {},
      "net_sales_money": {},
      "taxes": [
        {
          "errors": [
            {
              "category": "RATE_LIMIT_ERROR",
              "code": "RESERVATION_DECLINED",
              "detail": "detail0",
              "field": "field8"
            },
            {
              "category": "PAYMENT_METHOD_ERROR",
              "code": "UNKNOWN_BODY_PARAMETER",
              "detail": "detail1",
              "field": "field9"
            }
          ],
          "name": "name9",
          "applied_money": {},
          "rate": "rate1",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id7"
        },
        {
          "errors": [
            {
              "category": "PAYMENT_METHOD_ERROR",
              "code": "UNKNOWN_BODY_PARAMETER",
              "detail": "detail1",
              "field": "field9"
            },
            {
              "category": "REFUND_ERROR",
              "code": "NOT_FOUND",
              "detail": "detail2",
              "field": "field0"
            },
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "APPLE_PAYMENT_PROCESSING_CERTIFICATE_HASH_NOT_FOUND",
              "detail": "detail3",
              "field": "field1"
            }
          ],
          "name": "name0",
          "applied_money": {},
          "rate": "rate0",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id8"
        }
      ],
      "discounts": [
        {
          "name": "name7",
          "applied_money": {},
          "discount_id": "discount_id5"
        },
        {
          "name": "name8",
          "applied_money": {},
          "discount_id": "discount_id6"
        },
        {
          "name": "name9",
          "applied_money": {},
          "discount_id": "discount_id7"
        }
      ],
      "modifiers": [
        {
          "name": "name7",
          "applied_money": {},
          "modifier_option_id": "modifier_option_id3"
        },
        {
          "name": "name8",
          "applied_money": {},
          "modifier_option_id": "modifier_option_id4"
        }
      ]
    },
    {
      "name": "name7",
      "quantity": 167.23,
      "itemization_type": "OTHER",
      "item_detail": {
        "category_name": "category_name3",
        "sku": "sku9",
        "item_id": "item_id5",
        "item_variation_id": "item_variation_id9"
      },
      "notes": "notes7",
      "item_variation_name": "item_variation_name5",
      "total_money": {
        "amount": 9,
        "currency_code": "UGX"
      },
      "single_quantity_money": {
        "amount": 169,
        "currency_code": "USD"
      },
      "gross_sales_money": {},
      "discount_money": {},
      "net_sales_money": {},
      "taxes": [
        {
          "errors": [
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "ALLOWABLE_PIN_TRIES_EXCEEDED",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name8",
          "applied_money": {},
          "rate": "rate2",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id6"
        }
      ],
      "discounts": [
        {
          "name": "name8",
          "applied_money": {},
          "discount_id": "discount_id6"
        }
      ],
      "modifiers": [
        {
          "name": "name8",
          "applied_money": {},
          "modifier_option_id": "modifier_option_id4"
        },
        {
          "name": "name9",
          "applied_money": {},
          "modifier_option_id": "modifier_option_id5"
        },
        {
          "name": "name0",
          "applied_money": {},
          "modifier_option_id": "modifier_option_id6"
        }
      ]
    }
  ],
  "surcharge_money": {
    "amount": 74,
    "currency_code": "NOK"
  },
  "surcharges": [
    {
      "name": "name1",
      "applied_money": {
        "amount": 251,
        "currency_code": "KYD"
      },
      "rate": "rate9",
      "amount_money": {
        "amount": 131,
        "currency_code": "LTL"
      },
      "type": "CUSTOM",
      "taxable": true,
      "taxes": [
        {
          "errors": [
            {
              "category": "REFUND_ERROR",
              "code": "SANDBOX_NOT_SUPPORTED",
              "detail": "detail7",
              "field": "field5"
            }
          ],
          "name": "name6",
          "applied_money": {},
          "rate": "rate4",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id4"
        },
        {
          "errors": [
            {
              "category": "PAYMENT_METHOD_ERROR",
              "code": "UNEXPECTED_VALUE",
              "detail": "detail6",
              "field": "field4"
            },
            {
              "category": "REFUND_ERROR",
              "code": "SANDBOX_NOT_SUPPORTED",
              "detail": "detail7",
              "field": "field5"
            },
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "INVALID_EMAIL_ADDRESS",
              "detail": "detail8",
              "field": "field6"
            }
          ],
          "name": "name5",
          "applied_money": {},
          "rate": "rate5",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id3"
        }
      ],
      "surcharge_id": "surcharge_id3"
    },
    {
      "name": "name2",
      "applied_money": {
        "amount": 250,
        "currency_code": "KWD"
      },
      "rate": "rate8",
      "amount_money": {
        "amount": 132,
        "currency_code": "LVL"
      },
      "type": "AUTO_GRATUITY",
      "taxable": false,
      "taxes": [
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "INVALID_EMAIL_ADDRESS",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "API_ERROR",
              "code": "INVALID_PHONE_NUMBER",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name7",
          "applied_money": {},
          "rate": "rate3",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id5"
        }
      ],
      "surcharge_id": "surcharge_id2"
    },
    {
      "name": "name3",
      "applied_money": {
        "amount": 249,
        "currency_code": "KRW"
      },
      "rate": "rate7",
      "amount_money": {
        "amount": 133,
        "currency_code": "LYD"
      },
      "type": "UNKNOWN",
      "taxable": true,
      "taxes": [
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "INVALID_PHONE_NUMBER",
              "detail": "detail9",
              "field": "field7"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "CHECKOUT_EXPIRED",
              "detail": "detail0",
              "field": "field8"
            },
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "BAD_CERTIFICATE",
              "detail": "detail1",
              "field": "field9"
            }
          ],
          "name": "name8",
          "applied_money": {},
          "rate": "rate2",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id6"
        },
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "INVALID_EMAIL_ADDRESS",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "API_ERROR",
              "code": "INVALID_PHONE_NUMBER",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name7",
          "applied_money": {},
          "rate": "rate3",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id5"
        },
        {
          "errors": [
            {
              "category": "REFUND_ERROR",
              "code": "SANDBOX_NOT_SUPPORTED",
              "detail": "detail7",
              "field": "field5"
            }
          ],
          "name": "name6",
          "applied_money": {},
          "rate": "rate4",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id4"
        }
      ],
      "surcharge_id": "surcharge_id1"
    }
  ],
  "is_partial": false
}
```

