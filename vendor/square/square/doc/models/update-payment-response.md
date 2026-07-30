
# Update Payment Response

Defines the response returned by
[UpdatePayment](../../doc/apis/payments.md#update-payment).

## Structure

`UpdatePaymentResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `payment` | [`?Payment`](../../doc/models/payment.md) | Optional | Represents a payment processed by the Square API. | getPayment(): ?Payment | setPayment(?Payment payment): void |

## Example (as JSON)

```json
{
  "payment": {
    "amount_money": {
      "amount": 1000,
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
    "capabilities": [
      "EDIT_AMOUNT_UP",
      "EDIT_AMOUNT_DOWN",
      "EDIT_TIP_AMOUNT_UP",
      "EDIT_TIP_AMOUNT_DOWN"
    ],
    "card_details": {
      "auth_result_code": "68aLBM",
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
        "authorized_at": "2021-10-13T20:26:44.364Z"
      },
      "cvv_status": "CVV_ACCEPTED",
      "entry_method": "ON_FILE",
      "statement_description": "SQ *EXAMPLE TEST GOSQ.C",
      "status": "AUTHORIZED"
    },
    "created_at": "2021-10-13T20:26:44.191Z",
    "customer_id": "W92WH6P11H4Z77CTET0RNTGFW8",
    "delay_action": "CANCEL",
    "delay_duration": "PT168H",
    "delayed_until": "2021-10-20T20:26:44.191Z",
    "id": "1QjqpBVyrI9S4H9sTGDWU9JeiWdZY",
    "location_id": "L88917AVBK2S5",
    "note": "Example Note",
    "order_id": "nUSN9TdxpiK3SrQg3wzmf6r8LP9YY",
    "receipt_number": "1Qjq",
    "risk_evaluation": {
      "created_at": "2021-10-13T20:26:45.271Z",
      "risk_level": "NORMAL"
    },
    "source_type": "CARD",
    "status": "APPROVED",
    "tip_money": {
      "amount": 100,
      "currency": "USD"
    },
    "total_money": {
      "amount": 1100,
      "currency": "USD"
    },
    "updated_at": "2021-10-13T20:26:44.364Z",
    "version_token": "rDrXnqiS7fJgexccgdpzmwqTiXui1aIKCp9EchZ7trE6o"
  }
}
```

