
# Loyalty Promotion Available Time Data

Represents scheduling information that determines when purchases can qualify to earn points
from a [loyalty promotion](../../doc/models/loyalty-promotion.md).

## Structure

`LoyaltyPromotionAvailableTimeData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `startDate` | `?string` | Optional | The date that the promotion starts, in `YYYY-MM-DD` format. Square populates this field<br>based on the provided `time_periods`. | getStartDate(): ?string | setStartDate(?string startDate): void |
| `endDate` | `?string` | Optional | The date that the promotion ends, in `YYYY-MM-DD` format. Square populates this field<br>based on the provided `time_periods`. If an end date is not specified, an `ACTIVE` promotion<br>remains available until it is canceled. | getEndDate(): ?string | setEndDate(?string endDate): void |
| `timePeriods` | `string[]` | Required | A list of [iCalendar (RFC 5545) events](https://tools.ietf.org/html/rfc5545#section-3.6.1)<br>(`VEVENT`). Each event represents an available time period per day or days of the week.<br>A day can have a maximum of one available time period.<br><br>Only `DTSTART`, `DURATION`, and `RRULE` are supported. `DTSTART` and `DURATION` are required and<br>timestamps must be in local (unzoned) time format. Include `RRULE` to specify recurring promotions,<br>an end date (using the `UNTIL` keyword), or both. For more information, see<br>[Available time](https://developer.squareup.com/docs/loyalty-api/loyalty-promotions#available-time).<br><br>Note that `BEGIN:VEVENT` and `END:VEVENT` are optional in a `CreateLoyaltyPromotion` request<br>but are always included in the response. | getTimePeriods(): array | setTimePeriods(array timePeriods): void |

## Example (as JSON)

```json
{
  "start_date": "start_date6",
  "end_date": "end_date0",
  "time_periods": [
    "time_periods1",
    "time_periods2"
  ]
}
```

