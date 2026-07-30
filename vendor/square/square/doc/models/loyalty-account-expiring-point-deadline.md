
# Loyalty Account Expiring Point Deadline

Represents a set of points for a loyalty account that are scheduled to expire on a specific date.

## Structure

`LoyaltyAccountExpiringPointDeadline`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `points` | `int` | Required | The number of points scheduled to expire at the `expires_at` timestamp. | getPoints(): int | setPoints(int points): void |
| `expiresAt` | `string` | Required | The timestamp of when the points are scheduled to expire, in RFC 3339 format.<br>**Constraints**: *Minimum Length*: `1` | getExpiresAt(): string | setExpiresAt(string expiresAt): void |

## Example (as JSON)

```json
{
  "points": 236,
  "expires_at": "expires_at6"
}
```

