<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\OnboardingStatus;

class Onboarding extends BaseResource
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $signedUpAt;

    /**
     * Either "needs-data", "in-review" or "completed".
     * Indicates this current status of the organization’s onboarding process.
     *
     * @var string
     */
    public $status;

    /**
     * @var bool
     */
    public $canReceivePayments;

    /**
     * @var bool
     */
    public $canReceiveSettlements;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @return bool
     */
    public function needsData()
    {
        return $this->status === OnboardingStatus::NEEDS_DATA;
    }

    /**
     * @return bool
     */
    public function isInReview()
    {
        return $this->status === OnboardingStatus::IN_REVIEW;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === OnboardingStatus::COMPLETED;
    }
}
