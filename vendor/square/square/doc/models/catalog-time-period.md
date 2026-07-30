
# Catalog Time Period

Represents a time period - either a single period or a repeating period.

## Structure

`CatalogTimePeriod`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `event` | `?string` | Optional | An iCalendar (RFC 5545) [event](https://tools.ietf.org/html/rfc5545#section-3.6.1), which<br>specifies the name, timing, duration and recurrence of this time period.<br><br>Example:<br><br>```<br>DTSTART:20190707T180000<br>DURATION:P2H<br>RRULE:FREQ=WEEKLY;BYDAY=MO,WE,FR<br>```<br><br>Only `SUMMARY`, `DTSTART`, `DURATION` and `RRULE` fields are supported.<br>`DTSTART` must be in local (unzoned) time format. Note that while `BEGIN:VEVENT`<br>and `END:VEVENT` is not required in the request. The response will always<br>include them. | getEvent(): ?string | setEvent(?string event): void |

## Example (as JSON)

```json
{
  "event": "event0"
}
```

