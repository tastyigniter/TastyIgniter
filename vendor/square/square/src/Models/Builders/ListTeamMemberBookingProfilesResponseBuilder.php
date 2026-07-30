<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListTeamMemberBookingProfilesResponse;

/**
 * Builder for model ListTeamMemberBookingProfilesResponse
 *
 * @see ListTeamMemberBookingProfilesResponse
 */
class ListTeamMemberBookingProfilesResponseBuilder
{
    /**
     * @var ListTeamMemberBookingProfilesResponse
     */
    private $instance;

    private function __construct(ListTeamMemberBookingProfilesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list team member booking profiles response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListTeamMemberBookingProfilesResponse());
    }

    /**
     * Sets team member booking profiles field.
     */
    public function teamMemberBookingProfiles(?array $value): self
    {
        $this->instance->setTeamMemberBookingProfiles($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
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
     * Initializes a new list team member booking profiles response object.
     */
    public function build(): ListTeamMemberBookingProfilesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
