<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TeamMemberBookingProfile;

/**
 * Builder for model TeamMemberBookingProfile
 *
 * @see TeamMemberBookingProfile
 */
class TeamMemberBookingProfileBuilder
{
    /**
     * @var TeamMemberBookingProfile
     */
    private $instance;

    private function __construct(TeamMemberBookingProfile $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new team member booking profile Builder object.
     */
    public static function init(): self
    {
        return new self(new TeamMemberBookingProfile());
    }

    /**
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Sets display name field.
     */
    public function displayName(?string $value): self
    {
        $this->instance->setDisplayName($value);
        return $this;
    }

    /**
     * Sets is bookable field.
     */
    public function isBookable(?bool $value): self
    {
        $this->instance->setIsBookable($value);
        return $this;
    }

    /**
     * Unsets is bookable field.
     */
    public function unsetIsBookable(): self
    {
        $this->instance->unsetIsBookable();
        return $this;
    }

    /**
     * Sets profile image url field.
     */
    public function profileImageUrl(?string $value): self
    {
        $this->instance->setProfileImageUrl($value);
        return $this;
    }

    /**
     * Initializes a new team member booking profile object.
     */
    public function build(): TeamMemberBookingProfile
    {
        return CoreHelper::clone($this->instance);
    }
}
