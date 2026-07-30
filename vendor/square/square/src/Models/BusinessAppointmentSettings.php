<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The service appointment settings, including where and how the service is provided.
 */
class BusinessAppointmentSettings implements \JsonSerializable
{
    /**
     * @var array
     */
    private $locationTypes = [];

    /**
     * @var string|null
     */
    private $alignmentTime;

    /**
     * @var array
     */
    private $minBookingLeadTimeSeconds = [];

    /**
     * @var array
     */
    private $maxBookingLeadTimeSeconds = [];

    /**
     * @var array
     */
    private $anyTeamMemberBookingEnabled = [];

    /**
     * @var array
     */
    private $multipleServiceBookingEnabled = [];

    /**
     * @var string|null
     */
    private $maxAppointmentsPerDayLimitType;

    /**
     * @var array
     */
    private $maxAppointmentsPerDayLimit = [];

    /**
     * @var array
     */
    private $cancellationWindowSeconds = [];

    /**
     * @var Money|null
     */
    private $cancellationFeeMoney;

    /**
     * @var string|null
     */
    private $cancellationPolicy;

    /**
     * @var array
     */
    private $cancellationPolicyText = [];

    /**
     * @var array
     */
    private $skipBookingFlowStaffSelection = [];

    /**
     * Returns Location Types.
     * Types of the location allowed for bookings.
     * See [BusinessAppointmentSettingsBookingLocationType](#type-
     * businessappointmentsettingsbookinglocationtype) for possible values
     *
     * @return string[]|null
     */
    public function getLocationTypes(): ?array
    {
        if (count($this->locationTypes) == 0) {
            return null;
        }
        return $this->locationTypes['value'];
    }

    /**
     * Sets Location Types.
     * Types of the location allowed for bookings.
     * See [BusinessAppointmentSettingsBookingLocationType](#type-
     * businessappointmentsettingsbookinglocationtype) for possible values
     *
     * @maps location_types
     *
     * @param string[]|null $locationTypes
     */
    public function setLocationTypes(?array $locationTypes): void
    {
        $this->locationTypes['value'] = $locationTypes;
    }

    /**
     * Unsets Location Types.
     * Types of the location allowed for bookings.
     * See [BusinessAppointmentSettingsBookingLocationType](#type-
     * businessappointmentsettingsbookinglocationtype) for possible values
     */
    public function unsetLocationTypes(): void
    {
        $this->locationTypes = [];
    }

    /**
     * Returns Alignment Time.
     * Time units of a service duration for bookings.
     */
    public function getAlignmentTime(): ?string
    {
        return $this->alignmentTime;
    }

    /**
     * Sets Alignment Time.
     * Time units of a service duration for bookings.
     *
     * @maps alignment_time
     */
    public function setAlignmentTime(?string $alignmentTime): void
    {
        $this->alignmentTime = $alignmentTime;
    }

    /**
     * Returns Min Booking Lead Time Seconds.
     * The minimum lead time in seconds before a service can be booked. Bookings must be created at least
     * this far ahead of the booking's starting time.
     */
    public function getMinBookingLeadTimeSeconds(): ?int
    {
        if (count($this->minBookingLeadTimeSeconds) == 0) {
            return null;
        }
        return $this->minBookingLeadTimeSeconds['value'];
    }

    /**
     * Sets Min Booking Lead Time Seconds.
     * The minimum lead time in seconds before a service can be booked. Bookings must be created at least
     * this far ahead of the booking's starting time.
     *
     * @maps min_booking_lead_time_seconds
     */
    public function setMinBookingLeadTimeSeconds(?int $minBookingLeadTimeSeconds): void
    {
        $this->minBookingLeadTimeSeconds['value'] = $minBookingLeadTimeSeconds;
    }

    /**
     * Unsets Min Booking Lead Time Seconds.
     * The minimum lead time in seconds before a service can be booked. Bookings must be created at least
     * this far ahead of the booking's starting time.
     */
    public function unsetMinBookingLeadTimeSeconds(): void
    {
        $this->minBookingLeadTimeSeconds = [];
    }

    /**
     * Returns Max Booking Lead Time Seconds.
     * The maximum lead time in seconds before a service can be booked. Bookings must be created at most
     * this far ahead of the booking's starting time.
     */
    public function getMaxBookingLeadTimeSeconds(): ?int
    {
        if (count($this->maxBookingLeadTimeSeconds) == 0) {
            return null;
        }
        return $this->maxBookingLeadTimeSeconds['value'];
    }

    /**
     * Sets Max Booking Lead Time Seconds.
     * The maximum lead time in seconds before a service can be booked. Bookings must be created at most
     * this far ahead of the booking's starting time.
     *
     * @maps max_booking_lead_time_seconds
     */
    public function setMaxBookingLeadTimeSeconds(?int $maxBookingLeadTimeSeconds): void
    {
        $this->maxBookingLeadTimeSeconds['value'] = $maxBookingLeadTimeSeconds;
    }

    /**
     * Unsets Max Booking Lead Time Seconds.
     * The maximum lead time in seconds before a service can be booked. Bookings must be created at most
     * this far ahead of the booking's starting time.
     */
    public function unsetMaxBookingLeadTimeSeconds(): void
    {
        $this->maxBookingLeadTimeSeconds = [];
    }

    /**
     * Returns Any Team Member Booking Enabled.
     * Indicates whether a customer can choose from all available time slots and have a staff member
     * assigned
     * automatically (`true`) or not (`false`).
     */
    public function getAnyTeamMemberBookingEnabled(): ?bool
    {
        if (count($this->anyTeamMemberBookingEnabled) == 0) {
            return null;
        }
        return $this->anyTeamMemberBookingEnabled['value'];
    }

    /**
     * Sets Any Team Member Booking Enabled.
     * Indicates whether a customer can choose from all available time slots and have a staff member
     * assigned
     * automatically (`true`) or not (`false`).
     *
     * @maps any_team_member_booking_enabled
     */
    public function setAnyTeamMemberBookingEnabled(?bool $anyTeamMemberBookingEnabled): void
    {
        $this->anyTeamMemberBookingEnabled['value'] = $anyTeamMemberBookingEnabled;
    }

    /**
     * Unsets Any Team Member Booking Enabled.
     * Indicates whether a customer can choose from all available time slots and have a staff member
     * assigned
     * automatically (`true`) or not (`false`).
     */
    public function unsetAnyTeamMemberBookingEnabled(): void
    {
        $this->anyTeamMemberBookingEnabled = [];
    }

    /**
     * Returns Multiple Service Booking Enabled.
     * Indicates whether a customer can book multiple services in a single online booking.
     */
    public function getMultipleServiceBookingEnabled(): ?bool
    {
        if (count($this->multipleServiceBookingEnabled) == 0) {
            return null;
        }
        return $this->multipleServiceBookingEnabled['value'];
    }

    /**
     * Sets Multiple Service Booking Enabled.
     * Indicates whether a customer can book multiple services in a single online booking.
     *
     * @maps multiple_service_booking_enabled
     */
    public function setMultipleServiceBookingEnabled(?bool $multipleServiceBookingEnabled): void
    {
        $this->multipleServiceBookingEnabled['value'] = $multipleServiceBookingEnabled;
    }

    /**
     * Unsets Multiple Service Booking Enabled.
     * Indicates whether a customer can book multiple services in a single online booking.
     */
    public function unsetMultipleServiceBookingEnabled(): void
    {
        $this->multipleServiceBookingEnabled = [];
    }

    /**
     * Returns Max Appointments Per Day Limit Type.
     * Types of daily appointment limits.
     */
    public function getMaxAppointmentsPerDayLimitType(): ?string
    {
        return $this->maxAppointmentsPerDayLimitType;
    }

    /**
     * Sets Max Appointments Per Day Limit Type.
     * Types of daily appointment limits.
     *
     * @maps max_appointments_per_day_limit_type
     */
    public function setMaxAppointmentsPerDayLimitType(?string $maxAppointmentsPerDayLimitType): void
    {
        $this->maxAppointmentsPerDayLimitType = $maxAppointmentsPerDayLimitType;
    }

    /**
     * Returns Max Appointments Per Day Limit.
     * The maximum number of daily appointments per team member or per location.
     */
    public function getMaxAppointmentsPerDayLimit(): ?int
    {
        if (count($this->maxAppointmentsPerDayLimit) == 0) {
            return null;
        }
        return $this->maxAppointmentsPerDayLimit['value'];
    }

    /**
     * Sets Max Appointments Per Day Limit.
     * The maximum number of daily appointments per team member or per location.
     *
     * @maps max_appointments_per_day_limit
     */
    public function setMaxAppointmentsPerDayLimit(?int $maxAppointmentsPerDayLimit): void
    {
        $this->maxAppointmentsPerDayLimit['value'] = $maxAppointmentsPerDayLimit;
    }

    /**
     * Unsets Max Appointments Per Day Limit.
     * The maximum number of daily appointments per team member or per location.
     */
    public function unsetMaxAppointmentsPerDayLimit(): void
    {
        $this->maxAppointmentsPerDayLimit = [];
    }

    /**
     * Returns Cancellation Window Seconds.
     * The cut-off time in seconds for allowing clients to cancel or reschedule an appointment.
     */
    public function getCancellationWindowSeconds(): ?int
    {
        if (count($this->cancellationWindowSeconds) == 0) {
            return null;
        }
        return $this->cancellationWindowSeconds['value'];
    }

    /**
     * Sets Cancellation Window Seconds.
     * The cut-off time in seconds for allowing clients to cancel or reschedule an appointment.
     *
     * @maps cancellation_window_seconds
     */
    public function setCancellationWindowSeconds(?int $cancellationWindowSeconds): void
    {
        $this->cancellationWindowSeconds['value'] = $cancellationWindowSeconds;
    }

    /**
     * Unsets Cancellation Window Seconds.
     * The cut-off time in seconds for allowing clients to cancel or reschedule an appointment.
     */
    public function unsetCancellationWindowSeconds(): void
    {
        $this->cancellationWindowSeconds = [];
    }

    /**
     * Returns Cancellation Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getCancellationFeeMoney(): ?Money
    {
        return $this->cancellationFeeMoney;
    }

    /**
     * Sets Cancellation Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps cancellation_fee_money
     */
    public function setCancellationFeeMoney(?Money $cancellationFeeMoney): void
    {
        $this->cancellationFeeMoney = $cancellationFeeMoney;
    }

    /**
     * Returns Cancellation Policy.
     * The category of the seller’s cancellation policy.
     */
    public function getCancellationPolicy(): ?string
    {
        return $this->cancellationPolicy;
    }

    /**
     * Sets Cancellation Policy.
     * The category of the seller’s cancellation policy.
     *
     * @maps cancellation_policy
     */
    public function setCancellationPolicy(?string $cancellationPolicy): void
    {
        $this->cancellationPolicy = $cancellationPolicy;
    }

    /**
     * Returns Cancellation Policy Text.
     * The free-form text of the seller's cancellation policy.
     */
    public function getCancellationPolicyText(): ?string
    {
        if (count($this->cancellationPolicyText) == 0) {
            return null;
        }
        return $this->cancellationPolicyText['value'];
    }

    /**
     * Sets Cancellation Policy Text.
     * The free-form text of the seller's cancellation policy.
     *
     * @maps cancellation_policy_text
     */
    public function setCancellationPolicyText(?string $cancellationPolicyText): void
    {
        $this->cancellationPolicyText['value'] = $cancellationPolicyText;
    }

    /**
     * Unsets Cancellation Policy Text.
     * The free-form text of the seller's cancellation policy.
     */
    public function unsetCancellationPolicyText(): void
    {
        $this->cancellationPolicyText = [];
    }

    /**
     * Returns Skip Booking Flow Staff Selection.
     * Indicates whether customers has an assigned staff member (`true`) or can select s staff member of
     * their choice (`false`).
     */
    public function getSkipBookingFlowStaffSelection(): ?bool
    {
        if (count($this->skipBookingFlowStaffSelection) == 0) {
            return null;
        }
        return $this->skipBookingFlowStaffSelection['value'];
    }

    /**
     * Sets Skip Booking Flow Staff Selection.
     * Indicates whether customers has an assigned staff member (`true`) or can select s staff member of
     * their choice (`false`).
     *
     * @maps skip_booking_flow_staff_selection
     */
    public function setSkipBookingFlowStaffSelection(?bool $skipBookingFlowStaffSelection): void
    {
        $this->skipBookingFlowStaffSelection['value'] = $skipBookingFlowStaffSelection;
    }

    /**
     * Unsets Skip Booking Flow Staff Selection.
     * Indicates whether customers has an assigned staff member (`true`) or can select s staff member of
     * their choice (`false`).
     */
    public function unsetSkipBookingFlowStaffSelection(): void
    {
        $this->skipBookingFlowStaffSelection = [];
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
        if (!empty($this->locationTypes)) {
            $json['location_types']                      = $this->locationTypes['value'];
        }
        if (isset($this->alignmentTime)) {
            $json['alignment_time']                      = $this->alignmentTime;
        }
        if (!empty($this->minBookingLeadTimeSeconds)) {
            $json['min_booking_lead_time_seconds']       = $this->minBookingLeadTimeSeconds['value'];
        }
        if (!empty($this->maxBookingLeadTimeSeconds)) {
            $json['max_booking_lead_time_seconds']       = $this->maxBookingLeadTimeSeconds['value'];
        }
        if (!empty($this->anyTeamMemberBookingEnabled)) {
            $json['any_team_member_booking_enabled']     = $this->anyTeamMemberBookingEnabled['value'];
        }
        if (!empty($this->multipleServiceBookingEnabled)) {
            $json['multiple_service_booking_enabled']    = $this->multipleServiceBookingEnabled['value'];
        }
        if (isset($this->maxAppointmentsPerDayLimitType)) {
            $json['max_appointments_per_day_limit_type'] = $this->maxAppointmentsPerDayLimitType;
        }
        if (!empty($this->maxAppointmentsPerDayLimit)) {
            $json['max_appointments_per_day_limit']      = $this->maxAppointmentsPerDayLimit['value'];
        }
        if (!empty($this->cancellationWindowSeconds)) {
            $json['cancellation_window_seconds']         = $this->cancellationWindowSeconds['value'];
        }
        if (isset($this->cancellationFeeMoney)) {
            $json['cancellation_fee_money']              = $this->cancellationFeeMoney;
        }
        if (isset($this->cancellationPolicy)) {
            $json['cancellation_policy']                 = $this->cancellationPolicy;
        }
        if (!empty($this->cancellationPolicyText)) {
            $json['cancellation_policy_text']            = $this->cancellationPolicyText['value'];
        }
        if (!empty($this->skipBookingFlowStaffSelection)) {
            $json['skip_booking_flow_staff_selection']   = $this->skipBookingFlowStaffSelection['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
