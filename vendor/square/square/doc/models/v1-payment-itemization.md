
# V1 Payment Itemization

Payment include an`itemizations` field that lists the items purchased,
along with associated fees, modifiers, and discounts. Each itemization has an
`itemization_type` field that indicates which of the following the itemization
represents:

<ul>
<li>An item variation from the merchant's item library</li>
<li>A custom monetary amount</li>
<li>
An action performed on a Square gift card, such as activating or
reloading it.
</li>
</ul>
*Note**: itemization information included in a `Payment` object reflects
details collected **at the time of the payment**. Details such as the name or
price of items might have changed since the payment was processed.

## Structure

`V1PaymentItemization`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The item's name. | getName(): ?string | setName(?string name): void |
| `quantity` | `?float` | Optional | The quantity of the item purchased. This can be a decimal value. | getQuantity(): ?float | setQuantity(?float quantity): void |
| `itemizationType` | [`?string (V1PaymentItemizationItemizationType)`](../../doc/models/v1-payment-itemization-itemization-type.md) | Optional | - | getItemizationType(): ?string | setItemizationType(?string itemizationType): void |
| `itemDetail` | [`?V1PaymentItemDetail`](../../doc/models/v1-payment-item-detail.md) | Optional | V1PaymentItemDetail | getItemDetail(): ?V1PaymentItemDetail | setItemDetail(?V1PaymentItemDetail itemDetail): void |
| `notes` | `?string` | Optional | Notes entered by the merchant about the item at the time of payment, if any. | getNotes(): ?string | setNotes(?string notes): void |
| `itemVariationName` | `?string` | Optional | The name of the item variation purchased, if any. | getItemVariationName(): ?string | setItemVariationName(?string itemVariationName): void |
| `totalMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getTotalMoney(): ?V1Money | setTotalMoney(?V1Money totalMoney): void |
| `singleQuantityMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getSingleQuantityMoney(): ?V1Money | setSingleQuantityMoney(?V1Money singleQuantityMoney): void |
| `grossSalesMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getGrossSalesMoney(): ?V1Money | setGrossSalesMoney(?V1Money grossSalesMoney): void |
| `discountMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getDiscountMoney(): ?V1Money | setDiscountMoney(?V1Money discountMoney): void |
| `netSalesMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getNetSalesMoney(): ?V1Money | setNetSalesMoney(?V1Money netSalesMoney): void |
| `taxes` | [`?(V1PaymentTax[])`](../../doc/models/v1-payment-tax.md) | Optional | All taxes applied to this itemization. | getTaxes(): ?array | setTaxes(?array taxes): void |
| `discounts` | [`?(V1PaymentDiscount[])`](../../doc/models/v1-payment-discount.md) | Optional | All discounts applied to this itemization. | getDiscounts(): ?array | setDiscounts(?array discounts): void |
| `modifiers` | [`?(V1PaymentModifier[])`](../../doc/models/v1-payment-modifier.md) | Optional | All modifier options applied to this itemization. | getModifiers(): ?array | setModifiers(?array modifiers): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "quantity": 149.16,
  "itemization_type": "GIFT_CARD_UNKNOWN",
  "item_detail": {
    "category_name": "category_name0",
    "sku": "sku6",
    "item_id": "item_id2",
    "item_variation_id": "item_variation_id2"
  },
  "notes": "notes0",
  "item_variation_name": "item_variation_name2",
  "total_money": {
    "amount": 250,
    "currency_code": "USS"
  },
  "single_quantity_money": {
    "amount": 184,
    "currency_code": "TZS"
  },
  "gross_sales_money": {
    "amount": 198,
    "currency_code": "HKD"
  },
  "discount_money": {
    "amount": 92,
    "currency_code": "DJF"
  },
  "net_sales_money": {
    "amount": 110,
    "currency_code": "UZS"
  },
  "taxes": [
    {
      "errors": [
        {
          "category": "RATE_LIMIT_ERROR",
          "code": "MAP_KEY_LENGTH_TOO_SHORT",
          "detail": "detail6",
          "field": "field4"
        },
        {
          "category": "PAYMENT_METHOD_ERROR",
          "code": "MAP_KEY_LENGTH_TOO_LONG",
          "detail": "detail7",
          "field": "field5"
        }
      ],
      "name": "name5",
      "applied_money": {
        "amount": 109,
        "currency_code": "USN"
      },
      "rate": "rate5",
      "inclusion_type": "INCLUSIVE",
      "fee_id": "fee_id3"
    },
    {
      "errors": [
        {
          "category": "PAYMENT_METHOD_ERROR",
          "code": "MAP_KEY_LENGTH_TOO_LONG",
          "detail": "detail7",
          "field": "field5"
        },
        {
          "category": "REFUND_ERROR",
          "code": "CUSTOMER_MISSING_NAME",
          "detail": "detail8",
          "field": "field6"
        },
        {
          "category": "MERCHANT_SUBSCRIPTION_ERROR",
          "code": "CUSTOMER_MISSING_EMAIL",
          "detail": "detail9",
          "field": "field7"
        }
      ],
      "name": "name6",
      "applied_money": {
        "amount": 108,
        "currency_code": "USD"
      },
      "rate": "rate4",
      "inclusion_type": "ADDITIVE",
      "fee_id": "fee_id4"
    }
  ],
  "discounts": [
    {
      "name": "name1",
      "applied_money": {
        "amount": 97,
        "currency_code": "STD"
      },
      "discount_id": "discount_id9"
    },
    {
      "name": "name2",
      "applied_money": {
        "amount": 96,
        "currency_code": "SSP"
      },
      "discount_id": "discount_id0"
    },
    {
      "name": "name3",
      "applied_money": {
        "amount": 95,
        "currency_code": "SRD"
      },
      "discount_id": "discount_id1"
    }
  ],
  "modifiers": [
    {
      "name": "name1",
      "applied_money": {
        "amount": 135,
        "currency_code": "MZN"
      },
      "modifier_option_id": "modifier_option_id7"
    },
    {
      "name": "name2",
      "applied_money": {
        "amount": 134,
        "currency_code": "MYR"
      },
      "modifier_option_id": "modifier_option_id8"
    }
  ]
}
```

