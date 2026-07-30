<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [PauseSubscription]($e/Subscriptions/PauseSubscription) endpoint.
 */
class PauseSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $pauseEffectiveDate = [];

    /**
     * @var array
     */
    private $pauseCycleDuration = [];

    /**
     * @var array
     */
    private $resumeEffectiveDate = [];

    /**
     * @var string|null
     */
    private $resumeChangeTiming;

    /**
     * @var array
     */
    private $pauseReason = [];

    /**
     * Returns Pause Effective Date.
     * The `YYYY-MM-DD`-formatted date when the scheduled `PAUSE` action takes place on the subscription.
     *
     * When this date is unspecified or falls within the current billing cycle, the subscription is paused
     * on the starting date of the next billing cycle.
     */
    public function getPauseEffectiveDate(): ?string
    {
        if (count($this->pauseEffectiveDate) == 0) {
            return null;
        }
        return $this->pauseEffectiveDate['value'];
    }

    /**
     * Sets Pause Effective Date.
     * The `YYYY-MM-DD`-formatted date when the scheduled `PAUSE` action takes place on the subscription.
     *
     * When this date is unspecified or falls within the current billing cycle, the subscription is paused
     * on the starting date of the next billing cycle.
     *
     * @maps pause_effective_date
     */
    public function setPauseEffectiveDate(?string $pauseEffectiveDate): void
    {
        $this->pauseEffectiveDate['value'] = $pauseEffectiveDate;
    }

    /**
     * Unsets Pause Effective Date.
     * The `YYYY-MM-DD`-formatted date when the scheduled `PAUSE` action takes place on the subscription.
     *
     * When this date is unspecified or falls within the current billing cycle, the subscription is paused
     * on the starting date of the next billing cycle.
     */
    public function unsetPauseEffectiveDate(): void
    {
        $this->pauseEffectiveDate = [];
    }

    /**
     * Returns Pause Cycle Duration.
     * The number of billing cycles the subscription will be paused before it is reactivated.
     *
     * When this is set, a `RESUME` action is also scheduled to take place on the subscription at
     * the end of the specified pause cycle duration. In this case, neither `resume_effective_date`
     * nor `resume_change_timing` may be specified.
     */
    public function getPauseCycleDuration(): ?int
    {
        if (count($this->pauseCycleDuration) == 0) {
            return null;
        }
        return $this->pauseCycleDuration['value'];
    }

    /**
     * Sets Pause Cycle Duration.
     * The number of billing cycles the subscription will be paused before it is reactivated.
     *
     * When this is set, a `RESUME` action is also scheduled to take place on the subscription at
     * the end of the specified pause cycle duration. In this case, neither `resume_effective_date`
     * nor `resume_change_timing` may be specified.
     *
     * @maps pause_cycle_duration
     */
    public function setPauseCycleDuration(?int $pauseCycleDuration): void
    {
        $this->pauseCycleDuration['value'] = $pauseCycleDuration;
    }

    /**
     * Unsets Pause Cycle Duration.
     * The number of billing cycles the subscription will be paused before it is reactivated.
     *
     * When this is set, a `RESUME` action is also scheduled to take place on the subscription at
     * the end of the specified pause cycle duration. In this case, neither `resume_effective_date`
     * nor `resume_change_timing` may be specified.
     */
    public function unsetPauseCycleDuration(): void
    {
        $this->pauseCycleDuration = [];
    }

    /**
     * Returns Resume Effective Date.
     * The date when the subscription is reactivated by a scheduled `RESUME` action.
     * This date must be at least one billing cycle ahead of `pause_effective_date`.
     */
    public function getResumeEffectiveDate(): ?string
    {
        if (count($this->resumeEffectiveDate) == 0) {
            return null;
        }
        return $this->resumeEffectiveDate['value'];
    }

    /**
     * Sets Resume Effective Date.
     * The date when the subscription is reactivated by a scheduled `RESUME` action.
     * This date must be at least one billing cycle ahead of `pause_effective_date`.
     *
     * @maps resume_effective_date
     */
    public function setResumeEffectiveDate(?string $resumeEffectiveDate): void
    {
        $this->resumeEffectiveDate['value'] = $resumeEffectiveDate;
    }

    /**
     * Unsets Resume Effective Date.
     * The date when the subscription is reactivated by a scheduled `RESUME` action.
     * This date must be at least one billing cycle ahead of `pause_effective_date`.
     */
    public function unsetResumeEffectiveDate(): void
    {
        $this->resumeEffectiveDate = [];
    }

    /**
     * Returns Resume Change Timing.
     * Supported timings when a pending change, as an action, takes place to a subscription.
     */
    public function getResumeChangeTiming(): ?string
    {
        return $this->resumeChangeTiming;
    }

    /**
     * Sets Resume Change Timing.
     * Supported timings when a pending change, as an action, takes place to a subscription.
     *
     * @maps resume_change_timing
     */
    public function setResumeChangeTiming(?string $resumeChangeTiming): void
    {
        $this->resumeChangeTiming = $resumeChangeTiming;
    }

    /**
     * Returns Pause Reason.
     * The user-provided reason to pause the subscription.
     */
    public function getPauseReason(): ?string
    {
        if (count($this->pauseReason) == 0) {
            return null;
        }
        return $this->pauseReason['value'];
    }

    /**
     * Sets Pause Reason.
     * The user-provided reason to pause the subscription.
     *
     * @maps pause_reason
     */
    public function setPauseReason(?string $pauseReason): void
    {
        $this->pauseReason['value'] = $pauseReason;
    }

    /**
     * Unsets Pause Reason.
     * The user-provided reason to pause the subscription.
     */
    public function unsetPauseReason(): void
    {
        $this->pauseReason = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->pauseEffectiveDate)) {
            $json['pause_effective_date']  = $this->pauseEffectiveDate['value'];
        }
        if (!empty($this->pauseCycleDuration)) {
            $json['pause_cycle_duration']  = $this->pauseCycleDuration['value'];
        }
        if (!empty($this->resumeEffectiveDate)) {
            $json['resume_effective_date'] = $this->resumeEffectiveDate['value'];
        }
        if (isset($this->resumeChangeTiming)) {
            $json['resume_change_timing']  = $this->resumeChangeTiming;
        }
        if (!empty($this->pauseReason)) {
            $json['pause_reason']          = $this->pauseReason['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
