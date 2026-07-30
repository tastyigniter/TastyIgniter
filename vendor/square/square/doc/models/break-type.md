
# Break Type

A defined break template that sets an expectation for possible `Break`
instances on a `Shift`.

## Structure

`BreakType`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The UUID for this object.<br>**Constraints**: *Maximum Length*: `255` | getId(): ?string | setId(?string id): void |
| `locationId` | `string` | Required | The ID of the business location this type of break applies to.<br>**Constraints**: *Minimum Length*: `1` | getLocationId(): string | setLocationId(string locationId): void |
| `breakName` | `string` | Required | A human-readable name for this type of break. The name is displayed to<br>employees in Square products.<br>**Constraints**: *Minimum Length*: `1` | getBreakName(): string | setBreakName(string breakName): void |
| `expectedDuration` | `string` | Required | Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of<br>this break. Precision less than minutes is truncated.<br><br>Example for break expected duration of 15 minutes: T15M<br>**Constraints**: *Minimum Length*: `1` | getExpectedDuration(): string | setExpectedDuration(string expectedDuration): void |
| `isPaid` | `bool` | Required | Whether this break counts towards time worked for compensation<br>purposes. | getIsPaid(): bool | setIsPaid(bool isPaid): void |
| `version` | `?int` | Optional | Used for resolving concurrency issues. The request fails if the version<br>provided does not match the server version at the time of the request. If a value is not<br>provided, Square's servers execute a "blind" write; potentially<br>overwriting another writer's data. | getVersion(): ?int | setVersion(?int version): void |
| `createdAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | A read-only timestamp in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "location_id": "location_id4",
  "break_name": "break_name8",
  "expected_duration": "expected_duration4",
  "is_paid": false,
  "version": 172,
  "created_at": "created_at2",
  "updated_at": "updated_at4"
}
```

