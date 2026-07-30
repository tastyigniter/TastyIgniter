
# Loyalty Program Expiration Policy

Describes when the loyalty program expires.

## Structure

`LoyaltyProgramExpirationPolicy`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `expirationDuration` | `string` | Required | The number of months before points expire, in `P[n]M` RFC 3339 duration format. For example, a value of `P12M` represents a duration of 12 months.<br>Points are valid through the last day of the month in which they are scheduled to expire. For example, with a  `P12M` duration, points earned on July 6, 2020 expire on August 1, 2021.<br>**Constraints**: *Minimum Length*: `1` | getExpirationDuration(): string | setExpirationDuration(string expirationDuration): void |

## Example (as JSON)

```json
{
  "expiration_duration": "expiration_duration8"
}
```

