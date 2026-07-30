
# Bank Account Status

Indicates the current verification status of a `BankAccount` object.

## Enumeration

`BankAccountStatus`

## Fields

| Name | Description |
|  --- | --- |
| `VERIFICATION_IN_PROGRESS` | Indicates that the verification process has started. Some features<br>(for example, creditable or debitable) may be provisionally enabled on the bank<br>account. |
| `VERIFIED` | Indicates that the bank account was successfully verified. |
| `DISABLED` | Indicates that the bank account is disabled and is permanently unusable<br>for funds transfer. A bank account can be disabled because of a failed verification<br>attempt or a failed deposit attempt. |

