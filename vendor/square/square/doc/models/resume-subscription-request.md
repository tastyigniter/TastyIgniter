
# Resume Subscription Request

Defines input parameters in a request to the
[ResumeSubscription](../../doc/apis/subscriptions.md#resume-subscription) endpoint.

## Structure

`ResumeSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `resumeEffectiveDate` | `?string` | Optional | The `YYYY-MM-DD`-formatted date when the subscription reactivated. | getResumeEffectiveDate(): ?string | setResumeEffectiveDate(?string resumeEffectiveDate): void |
| `resumeChangeTiming` | [`?string (ChangeTiming)`](../../doc/models/change-timing.md) | Optional | Supported timings when a pending change, as an action, takes place to a subscription. | getResumeChangeTiming(): ?string | setResumeChangeTiming(?string resumeChangeTiming): void |

## Example (as JSON)

```json
{
  "resume_effective_date": "resume_effective_date2",
  "resume_change_timing": "IMMEDIATE"
}
```

