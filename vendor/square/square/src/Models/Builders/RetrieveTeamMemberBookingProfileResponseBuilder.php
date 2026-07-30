<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveTeamMemberBookingProfileResponse;
use Square\Models\TeamMemberBookingProfile;

/**
 * Builder for model RetrieveTeamMemberBookingProfileResponse
 *
 * @see RetrieveTeamMemberBookingProfileResponse
 */
class RetrieveTeamMemberBookingProfileResponseBuilder
{
    /**
     * @var RetrieveTeamMemberBookingProfileResponse
     */
    private $instance;

    private function __construct(RetrieveTeamMemberBookingProfileResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve team member booking profile response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveTeamMemberBookingProfileResponse());
    }

    /**
     * Sets team member booking profile field.
     */
    public function teamMemberBookingProfile(?TeamMemberBookingProfile $value): self
    {
        $this->instance->setTeamMemberBookingProfile($value);
        return $this;
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new retrieve team member booking profile response object.
     */
    public function build(): RetrieveTeamMemberBookingProfileResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
