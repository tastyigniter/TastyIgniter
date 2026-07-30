
# Pause Subscription Request

Defines input parameters in a request to the
[PauseSubscription](../../doc/apis/subscriptions.md#pause-subscription) endpoint.

## Structure

`PauseSubscriptionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `pauseEffectiveDate` | `?string` | Optional | The `YYYY-MM-DD`-formatted date when the scheduled `PAUSE` action takes place on the subscription.<br><br>When this date is unspecified or falls within the current billing cycle, the subscription is paused<br>on the starting date of the next billing cycle. | getPauseEffectiveDate(): ?string | setPauseEffectiveDate(?string pauseEffectiveDate): void |
| `pauseCycleDuration` | `?int` | Optional | The number of billing cycles the subscription will be paused before it is reactivated.<br><br>When this is set, a `RESUME` action is also scheduled to take place on the subscription at<br>the end of the specified pause cycle duration. In this case, neither `resume_effective_date`<br>nor `resume_change_timing` may be specified. | getPauseCycleDuration(): ?int | setPauseCycleDuration(?int pauseCycleDuration): void |
| `resumeEffectiveDate` | `?string` | Optional | The date when the subscription is reactivated by a scheduled `RESUME` action.<br>This date must be at least one billing cycle ahead of `pause_effective_date`. | getResumeEffectiveDate(): ?string | setResumeEffectiveDate(?string resumeEffectiveDate): void |
| `resumeChangeTiming` | [`?string (ChangeTiming)`](../../doc/models/change-timing.md) | Optional | Supported timings when a pending change, as an action, takes place to a subscription. | getResumeChangeTiming(): ?string | setResumeChangeTiming(?string resumeChangeTiming): void |
| `pauseReason` | `?string` | Optional | The user-provided reason to pause the subscription.<br>**Constraints**: *Maximum Length*: `255` | getPauseReason(): ?string | setPauseReason(?string pauseReason): void |

## Example (as JSON)

```json
{
  "pause_effective_date": "pause_effective_date0",
  "pause_cycle_duration": 86,
  "resume_effective_date": "resume_effective_date2",
  "resume_change_timing": "IMMEDIATE",
  "pause_reason": "pause_reason8"
}
```

