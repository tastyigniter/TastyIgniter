
# V1 Phone Number

Represents a phone number.

## Structure

`V1PhoneNumber`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `callingCode` | `string` | Required | The phone number's international calling code. For US phone numbers, this value is +1. | getCallingCode(): string | setCallingCode(string callingCode): void |
| `number` | `string` | Required | The phone number. | getNumber(): string | setNumber(string number): void |

## Example (as JSON)

```json
{
  "calling_code": "calling_code4",
  "number": "number2"
}
```

