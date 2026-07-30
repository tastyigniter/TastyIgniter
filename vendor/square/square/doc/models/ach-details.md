
# ACH Details

ACH-specific details about `BANK_ACCOUNT` type payments with the `transfer_type` of `ACH`.

## Structure

`ACHDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `routingNumber` | `?string` | Optional | The routing number for the bank account.<br>**Constraints**: *Maximum Length*: `50` | getRoutingNumber(): ?string | setRoutingNumber(?string routingNumber): void |
| `accountNumberSuffix` | `?string` | Optional | The last few digits of the bank account number.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `4` | getAccountNumberSuffix(): ?string | setAccountNumberSuffix(?string accountNumberSuffix): void |
| `accountType` | `?string` | Optional | The type of the bank account performing the transfer. The account type can be `CHECKING`,<br>`SAVINGS`, or `UNKNOWN`.<br>**Constraints**: *Maximum Length*: `50` | getAccountType(): ?string | setAccountType(?string accountType): void |

## Example (as JSON)

```json
{
  "routing_number": "routing_number4",
  "account_number_suffix": "account_number_suffix8",
  "account_type": "account_type4"
}
```

