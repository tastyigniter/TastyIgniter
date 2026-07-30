
# Create Payment Response

Defines the response returned by [CreatePayment](../../doc/apis/payments.md#create-payment).

If there are errors processing the request, the `payment` field might not be
present, or it might be present with a status of `FAILED`.

## Structure

`CreatePaymentResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `payment` | [`?Payment`](../../doc/models/payment.md) | Optional | Represents a payment processed by the Square API. | getPayment(): ?Payment | setPayment(?Payment payment): void |

## Example (as JSON)

```json
{
  "payment": {
    "amount_money": {
      "amount": 1000,
      "currency": "USD"
    },
    "app_fee_money": {
      "amount": 10,
      "currency": "USD"
    },
    "application_details": {
      "application_id": "sq0ids-TcgftTEtKxJTRF1lCFJ9TA",
      "square_product": "ECOMMERCE_API"
    },
    "approved_money": {
      "amount": 1000,
      "currency": "USD"
    },
    "card_details": {
      "auth_result_code": "vNEn2f",
      "avs_status": "AVS_ACCEPTED",
      "card": {
        "bin": "411111",
        "card_brand": "VISA",
        "card_type": "DEBIT",
        "exp_month": 11,
        "exp_year": 2022,
        "fingerprint": "sq-1-Hxim77tbdcbGejOejnoAklBVJed2YFLTmirfl8Q5XZzObTc8qY_U8RkwzoNL8dCEcQ",
        "last_4": "1111",
        "prepaid_type": "NOT_PREPAID"
      },
      "card_payment_timeline": {
        "authorized_at": "2021-10-13T21:14:29.732Z",
        "captured_at": "2021-10-13T21:14:30.504Z"
      },
      "cvv_status": "CVV_ACCEPTED",
      "entry_method": "ON_FILE",
      "statement_description": "SQ *EXAMPLE TEST GOSQ.C",
      "status": "CAPTURED"
    },
    "created_at": "2021-10-13T21:14:29.577Z",
    "customer_id": "W92WH6P11H4Z77CTET0RNTGFW8",
    "delay_action": "CANCEL",
    "delay_duration": "PT168H",
    "delayed_until": "2021-10-20T21:14:29.577Z",
    "id": "R2B3Z8WMVt3EAmzYWLZvz7Y69EbZY",
    "location_id": "L88917AVBK2S5",
    "note": "Brief Description",
    "order_id": "pRsjRTgFWATl7so6DxdKBJa7ssbZY",
    "receipt_number": "R2B3",
    "receipt_url": "https://squareup.com/receipt/preview/EXAMPLE_RECEIPT_ID",
    "reference_id": "123456",
    "risk_evaluation": {
      "created_at": "2021-10-13T21:14:30.423Z",
      "risk_level": "NORMAL"
    },
    "source_type": "CARD",
    "status": "COMPLETED",
    "total_money": {
      "amount": 1000,
      "currency": "USD"
    },
    "updated_at": "2021-10-13T21:14:30.504Z",
    "version_token": "TPtNEOBOa6Qq6E3C3IjckSVOM6b3hMbfhjvTxHBQUsB6o"
  }
}
```

