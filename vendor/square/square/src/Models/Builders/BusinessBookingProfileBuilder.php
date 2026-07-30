<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BusinessAppointmentSettings;
use Square\Models\BusinessBookingProfile;

/**
 * Builder for model BusinessBookingProfile
 *
 * @see BusinessBookingProfile
 */
class BusinessBookingProfileBuilder
{
    /**
     * @var BusinessBookingProfile
     */
    private $instance;

    private function __construct(BusinessBookingProfile $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new business booking profile Builder object.
     */
    public static function init(): self
    {
        return new self(new BusinessBookingProfile());
    }

    /**
     * Sets seller id field.
     */
    public function sellerId(?string $value): self
    {
        $this->instance->setSellerId($value);
        return $this;
    }

    /**
     * Unsets seller id field.
     */
    public function unsetSellerId(): self
    {
        $this->instance->unsetSellerId();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets booking enabled field.
     */
    public function bookingEnabled(?bool $value): self
    {
        $this->instance->setBookingEnabled($value);
        return $this;
    }

    /**
     * Unsets booking enabled field.
     */
    public function unsetBookingEnabled(): self
    {
        $this->instance->unsetBookingEnabled();
        return $this;
    }

    /**
     * Sets customer timezone choice field.
     */
    public function customerTimezoneChoice(?string $value): self
    {
        $this->instance->setCustomerTimezoneChoice($value);
        return $this;
    }

    /**
     * Sets booking policy field.
     */
    public function bookingPolicy(?string $value): self
    {
        $this->instance->setBookingPolicy($value);
        return $this;
    }

    /**
     * Sets allow user cancel field.
     */
    public function allowUserCancel(?bool $value): self
    {
        $this->instance->setAllowUserCancel($value);
        return $this;
    }

    /**
     * Unsets allow user cancel field.
     */
    public function unsetAllowUserCancel(): self
    {
        $this->instance->unsetAllowUserCancel();
        return $this;
    }

    /**
     * Sets business appointment settings field.
     */
    public function businessAppointmentSettings(?BusinessAppointmentSettings $value): self
    {
        $this->instance->setBusinessAppointmentSettings($value);
        return $this;
    }

    /**
     * Sets support seller level writes field.
     */
    public function supportSellerLevelWrites(?bool $value): self
    {
        $this->instance->setSupportSellerLevelWrites($value);
        return $this;
    }

    /**
     * Unsets support seller level writes field.
     */
    public function unsetSupportSellerLevelWrites(): self
    {
        $this->instance->unsetSupportSellerLevelWrites();
        return $this;
    }

    /**
     * Initializes a new business booking profile object.
     */
    public function build(): BusinessBookingProfile
    {
        return CoreHelper::clone($this->instance);
    }
}
