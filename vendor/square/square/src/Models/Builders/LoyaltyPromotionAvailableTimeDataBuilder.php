<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyPromotionAvailableTimeData;

/**
 * Builder for model LoyaltyPromotionAvailableTimeData
 *
 * @see LoyaltyPromotionAvailableTimeData
 */
class LoyaltyPromotionAvailableTimeDataBuilder
{
    /**
     * @var LoyaltyPromotionAvailableTimeData
     */
    private $instance;

    private function __construct(LoyaltyPromotionAvailableTimeData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty promotion available time data Builder object.
     */
    public static function init(array $timePeriods): self
    {
        return new self(new LoyaltyPromotionAvailableTimeData($timePeriods));
    }

    /**
     * Sets start date field.
     */
    public function startDate(?string $value): self
    {
        $this->instance->setStartDate($value);
        return $this;
    }

    /**
     * Sets end date field.
     */
    public function endDate(?string $value): self
    {
        $this->instance->setEndDate($value);
        return $this;
    }

    /**
     * Initializes a new loyalty promotion available time data object.
     */
    public function build(): LoyaltyPromotionAvailableTimeData
    {
        return CoreHelper::clone($this->instance);
    }
}
