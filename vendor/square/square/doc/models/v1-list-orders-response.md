
# V1 List Orders Response

## Structure

`V1ListOrdersResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `items` | [`?(V1Order[])`](../../doc/models/v1-order.md) | Optional | - | getItems(): ?array | setItems(?array items): void |

## Example (as JSON)

```json
{
  "items": [
    {
      "errors": [
        {
          "category": "MERCHANT_SUBSCRIPTION_ERROR",
          "code": "GENERIC_DECLINE",
          "detail": "detail8",
          "field": "field6"
        },
        {
          "category": "API_ERROR",
          "code": "CVV_FAILURE",
          "detail": "detail9",
          "field": "field7"
        },
        {
          "category": "AUTHENTICATION_ERROR",
          "code": "ADDRESS_VERIFICATION_FAILURE",
          "detail": "detail0",
          "field": "field8"
        }
      ],
      "id": "id7",
      "buyer_email": "buyer_email1",
      "recipient_name": "recipient_name5",
      "recipient_phone_number": "recipient_phone_number7",
      "state": "REJECTED",
      "shipping_address": {
        "address_line_1": "address_line_17",
        "address_line_2": "address_line_23",
        "address_line_3": "address_line_39",
        "locality": "locality3",
        "sublocality": "sublocality3",
        "sublocality_2": "sublocality_21",
        "sublocality_3": "sublocality_33",
        "administrative_district_level_1": "administrative_district_level_17",
        "administrative_district_level_2": "administrative_district_level_21",
        "administrative_district_level_3": "administrative_district_level_31",
        "postal_code": "postal_code5",
        "country": "HN",
        "first_name": "first_name3",
        "last_name": "last_name1"
      },
      "subtotal_money": {
        "amount": 199,
        "currency_code": "JMD"
      },
      "total_shipping_money": {
        "amount": 177,
        "currency_code": "XAG"
      },
      "total_tax_money": {},
      "total_price_money": {},
      "total_discount_money": {},
      "created_at": "created_at5",
      "updated_at": "updated_at7",
      "expires_at": "expires_at9",
      "payment_id": "payment_id7",
      "buyer_note": "buyer_note9",
      "completed_note": "completed_note7",
      "refunded_note": "refunded_note1",
      "canceled_note": "canceled_note3",
      "tender": {
        "id": "id3",
        "type": "CASH",
        "name": "name3",
        "employee_id": "employee_id3",
        "receipt_url": "receipt_url5",
        "card_brand": "JCB",
        "pan_suffix": "pan_suffix3",
        "entry_method": "SQUARE_CASH",
        "payment_note": "payment_note1",
        "total_money": {},
        "tendered_money": {},
        "tendered_at": "tendered_at7",
        "settled_at": "settled_at9",
        "change_back_money": {},
        "refunded_money": {},
        "is_exchange": true
      },
      "order_history": [
        {
          "action": "ORDER_PLACED",
          "created_at": "created_at2"
        }
      ],
      "promo_code": "promo_code5",
      "btc_receive_address": "btc_receive_address5",
      "btc_price_satoshi": 114.71
    },
    {
      "errors": [
        {
          "category": "API_ERROR",
          "code": "CVV_FAILURE",
          "detail": "detail9",
          "field": "field7"
        }
      ],
      "id": "id8",
      "buyer_email": "buyer_email0",
      "recipient_name": "recipient_name6",
      "recipient_phone_number": "recipient_phone_number6",
      "state": "REFUNDED",
      "shipping_address": {
        "address_line_1": "address_line_18",
        "address_line_2": "address_line_22",
        "address_line_3": "address_line_38",
        "locality": "locality2",
        "sublocality": "sublocality2",
        "sublocality_2": "sublocality_20",
        "sublocality_3": "sublocality_32",
        "administrative_district_level_1": "administrative_district_level_16",
        "administrative_district_level_2": "administrative_district_level_22",
        "administrative_district_level_3": "administrative_district_level_30",
        "postal_code": "postal_code4",
        "country": "HM",
        "first_name": "first_name2",
        "last_name": "last_name0"
      },
      "subtotal_money": {
        "amount": 200,
        "currency_code": "JOD"
      },
      "total_shipping_money": {
        "amount": 178,
        "currency_code": "XAU"
      },
      "total_tax_money": {},
      "total_price_money": {},
      "total_discount_money": {},
      "created_at": "created_at6",
      "updated_at": "updated_at6",
      "expires_at": "expires_at8",
      "payment_id": "payment_id8",
      "buyer_note": "buyer_note0",
      "completed_note": "completed_note8",
      "refunded_note": "refunded_note2",
      "canceled_note": "canceled_note2",
      "tender": {
        "id": "id4",
        "type": "THIRD_PARTY_CARD",
        "name": "name4",
        "employee_id": "employee_id4",
        "receipt_url": "receipt_url6",
        "card_brand": "CHINA_UNIONPAY",
        "pan_suffix": "pan_suffix4",
        "entry_method": "SQUARE_WALLET",
        "payment_note": "payment_note2",
        "total_money": {},
        "tendered_money": {},
        "tendered_at": "tendered_at8",
        "settled_at": "settled_at0",
        "change_back_money": {},
        "refunded_money": {},
        "is_exchange": false
      },
      "order_history": [
        {
          "action": "DECLINED",
          "created_at": "created_at3"
        },
        {
          "action": "PAYMENT_RECEIVED",
          "created_at": "created_at4"
        }
      ],
      "promo_code": "promo_code4",
      "btc_receive_address": "btc_receive_address6",
      "btc_price_satoshi": 114.72
    }
  ]
}
```

