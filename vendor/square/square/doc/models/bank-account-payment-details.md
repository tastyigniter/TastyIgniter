
# Bank Account Payment Details

Additional details about BANK_ACCOUNT type payments.

## Structure

`BankAccountPaymentDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `bankName` | `?string` | Optional | The name of the bank associated with the bank account.<br>**Constraints**: *Maximum Length*: `100` | getBankName(): ?string | setBankName(?string bankName): void |
| `transferType` | `?string` | Optional | The type of the bank transfer. The type can be `ACH` or `UNKNOWN`.<br>**Constraints**: *Maximum Length*: `50` | getTransferType(): ?string | setTransferType(?string transferType): void |
| `accountOwnershipType` | `?string` | Optional | The ownership type of the bank account performing the transfer.<br>The type can be `INDIVIDUAL`, `COMPANY`, or `ACCOUNT_TYPE_UNKNOWN`.<br>**Constraints**: *Maximum Length*: `50` | getAccountOwnershipType(): ?string | setAccountOwnershipType(?string accountOwnershipType): void |
| `fingerprint` | `?string` | Optional | Uniquely identifies the bank account for this seller and can be used<br>to determine if payments are from the same bank account.<br>**Constraints**: *Maximum Length*: `255` | getFingerprint(): ?string | setFingerprint(?string fingerprint): void |
| `country` | `?string` | Optional | The two-letter ISO code representing the country the bank account is located in.<br>**Constraints**: *Minimum Length*: `2`, *Maximum Length*: `2` | getCountry(): ?string | setCountry(?string country): void |
| `statementDescription` | `?string` | Optional | The statement description as sent to the bank.<br>**Constraints**: *Maximum Length*: `1000` | getStatementDescription(): ?string | setStatementDescription(?string statementDescription): void |
| `achDetails` | [`?ACHDetails`](../../doc/models/ach-details.md) | Optional | ACH-specific details about `BANK_ACCOUNT` type payments with the `transfer_type` of `ACH`. | getAchDetails(): ?ACHDetails | setAchDetails(?ACHDetails achDetails): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |

## Example (as JSON)

```json
{
  "bank_name": "bank_name4",
  "transfer_type": "transfer_type8",
  "account_ownership_type": "account_ownership_type8",
  "fingerprint": "fingerprint6",
  "country": "country4",
  "statement_description": "statement_description4",
  "ach_details": {
    "routing_number": "routing_number0",
    "account_number_suffix": "account_number_suffix2",
    "account_type": "account_type2"
  },
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
  ]
}
```

