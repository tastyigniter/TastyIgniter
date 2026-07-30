<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [ResumeSubscription]($e/Subscriptions/ResumeSubscription) endpoint.
 */
class ResumeSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $resumeEffectiveDate = [];

    /**
     * @var string|null
     */
    private $resumeChangeTiming;

    /**
     * Returns Resume Effective Date.
     * The `YYYY-MM-DD`-formatted date when the subscription reactivated.
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
     * The `YYYY-MM-DD`-formatted date when the subscription reactivated.
     *
     * @maps resume_effective_date
     */
    public function setResumeEffectiveDate(?string $resumeEffectiveDate): void
    {
        $this->resumeEffectiveDate['value'] = $resumeEffectiveDate;
    }

    /**
     * Unsets Resume Effective Date.
     * The `YYYY-MM-DD`-formatted date when the subscription reactivated.
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
        if (!empty($this->resumeEffectiveDate)) {
            $json['resume_effective_date'] = $this->resumeEffectiveDate['value'];
        }
        if (isset($this->resumeChangeTiming)) {
            $json['resume_change_timing']  = $this->resumeChangeTiming;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
