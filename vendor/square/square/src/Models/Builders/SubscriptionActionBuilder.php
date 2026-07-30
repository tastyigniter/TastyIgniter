<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SubscriptionAction;

/**
 * Builder for model SubscriptionAction
 *
 * @see SubscriptionAction
 */
class SubscriptionActionBuilder
{
    /**
     * @var SubscriptionAction
     */
    private $instance;

    private function __construct(SubscriptionAction $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription action Builder object.
     */
    public static function init(): self
    {
        return new self(new SubscriptionAction());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets effective date field.
     */
    public function effectiveDate(?string $value): self
    {
        $this->instance->setEffectiveDate($value);
        return $this;
    }

    /**
     * Unsets effective date field.
     */
    public function unsetEffectiveDate(): self
    {
        $this->instance->unsetEffectiveDate();
        return $this;
    }

    /**
     * Sets new plan id field.
     */
    public function newPlanId(?string $value): self
    {
        $this->instance->setNewPlanId($value);
        return $this;
    }

    /**
     * Unsets new plan id field.
     */
    public function unsetNewPlanId(): self
    {
        $this->instance->unsetNewPlanId();
        return $this;
    }

    /**
     * Initializes a new subscription action object.
     */
    public function build(): SubscriptionAction
    {
        return CoreHelper::clone($this->instance);
    }
}
