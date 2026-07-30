<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BusinessBookingProfile;
use Square\Models\RetrieveBusinessBookingProfileResponse;

/**
 * Builder for model RetrieveBusinessBookingProfileResponse
 *
 * @see RetrieveBusinessBookingProfileResponse
 */
class RetrieveBusinessBookingProfileResponseBuilder
{
    /**
     * @var RetrieveBusinessBookingProfileResponse
     */
    private $instance;

    private function __construct(RetrieveBusinessBookingProfileResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve business booking profile response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveBusinessBookingProfileResponse());
    }

    /**
     * Sets business booking profile field.
     */
    public function businessBookingProfile(?BusinessBookingProfile $value): self
    {
        $this->instance->setBusinessBookingProfile($value);
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
     * Initializes a new retrieve business booking profile response object.
     */
    public function build(): RetrieveBusinessBookingProfileResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
