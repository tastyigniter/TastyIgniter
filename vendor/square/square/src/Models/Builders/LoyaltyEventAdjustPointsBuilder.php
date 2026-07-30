<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LoyaltyEventAdjustPoints;

/**
 * Builder for model LoyaltyEventAdjustPoints
 *
 * @see LoyaltyEventAdjustPoints
 */
class LoyaltyEventAdjustPointsBuilder
{
    /**
     * @var LoyaltyEventAdjustPoints
     */
    private $instance;

    private function __construct(LoyaltyEventAdjustPoints $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new loyalty event adjust points Builder object.
     */
    public static function init(int $points): self
    {
        return new self(new LoyaltyEventAdjustPoints($points));
    }

    /**
     * Sets loyalty program id field.
     */
    public function loyaltyProgramId(?string $value): self
    {
        $this->instance->setLoyaltyProgramId($value);
        return $this;
    }

    /**
     * Sets reason field.
     */
    public function reason(?string $value): self
    {
        $this->instance->setReason($value);
        return $this;
    }

    /**
     * Unsets reason field.
     */
    public function unsetReason(): self
    {
        $this->instance->unsetReason();
        return $this;
    }

    /**
     * Initializes a new loyalty event adjust points object.
     */
    public function build(): LoyaltyEventAdjustPoints
    {
        return CoreHelper::clone($this->instance);
    }
}
