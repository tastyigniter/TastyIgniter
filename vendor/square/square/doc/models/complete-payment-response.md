
# Complete Payment Response

Defines the response returned by[CompletePayment](../../doc/apis/payments.md#complete-payment).

## Structure

`CompletePaymentResponse`

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
      "amount": 555,
      "currency": "USD"
    },
    "application_details": {
      "application_id": "sq0ids-Pw67AZAlLVB7hsRmwlJPuA",
      "square_product": "VIRTUAL_TERMINAL"
    },
    "approved_money": {
      "amount": 555,
      "currency": "USD"
    },
    "card_details": {
      "auth_result_code": "2Nkw7q",
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
        "authorized_at": "2021-10-13T19:34:33.680Z",
        "captured_at": "2021-10-13T19:34:34.340Z"
      },
      "cvv_status": "CVV_ACCEPTED",
      "entry_method": "KEYED",
      "statement_description": "SQ *EXAMPLE TEST GOSQ.C",
      "status": "CAPTURED"
    },
    "created_at": "2021-10-13T19:34:33.524Z",
    "delay_action": "CANCEL",
    "delay_duration": "PT168H",
    "delayed_until": "2021-10-20T19:34:33.524Z",
    "employee_id": "TMoK_ogh6rH1o4dV",
    "id": "bP9mAsEMYPUGjjGNaNO5ZDVyLhSZY",
    "location_id": "L88917AVBK2S5",
    "note": "Test Note",
    "order_id": "d7eKah653Z579f3gVtjlxpSlmUcZY",
    "processing_fee": [
      {
        "amount_money": {
          "amount": 34,
          "currency": "USD"
        },
        "effective_at": "2021-10-13T21:34:35.000Z",
        "type": "INITIAL"
      }
    ],
    "receipt_number": "bP9m",
    "receipt_url": "https://squareup.com/receipt/preview/bP9mAsEMYPUGjjGNaNO5ZDVyLhSZY",
    "source_type": "CARD",
    "status": "COMPLETED",
    "team_member_id": "TMoK_ogh6rH1o4dV",
    "total_money": {
      "amount": 555,
      "currency": "USD"
    },
    "updated_at": "2021-10-13T19:34:34.339Z",
    "version_token": "56pRkL3slrzet2iQrTp9n0bdJVYTB9YEWdTNjQfZOPV6o"
  }
}
```

