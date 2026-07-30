<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\SubscriptionPhase;

/**
 * Builder for model SubscriptionPhase
 *
 * @see SubscriptionPhase
 */
class SubscriptionPhaseBuilder
{
    /**
     * @var SubscriptionPhase
     */
    private $instance;

    private function __construct(SubscriptionPhase $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription phase Builder object.
     */
    public static function init(string $cadence): self
    {
        return new self(new SubscriptionPhase($cadence));
    }

    /**
     * Sets uid field.
     */
    public function uid(?string $value): self
    {
        $this->instance->setUid($value);
        return $this;
    }

    /**
     * Unsets uid field.
     */
    public function unsetUid(): self
    {
        $this->instance->unsetUid();
        return $this;
    }

    /**
     * Sets periods field.
     */
    public function periods(?int $value): self
    {
        $this->instance->setPeriods($value);
        return $this;
    }

    /**
     * Unsets periods field.
     */
    public function unsetPeriods(): self
    {
        $this->instance->unsetPeriods();
        return $this;
    }

    /**
     * Sets recurring price money field.
     */
    public function recurringPriceMoney(?Money $value): self
    {
        $this->instance->setRecurringPriceMoney($value);
        return $this;
    }

    /**
     * Sets ordinal field.
     */
    public function ordinal(?int $value): self
    {
        $this->instance->setOrdinal($value);
        return $this;
    }

    /**
     * Unsets ordinal field.
     */
    public function unsetOrdinal(): self
    {
        $this->instance->unsetOrdinal();
        return $this;
    }

    /**
     * Initializes a new subscription phase object.
     */
    public function build(): SubscriptionPhase
    {
        return CoreHelper::clone($this->instance);
    }
}
