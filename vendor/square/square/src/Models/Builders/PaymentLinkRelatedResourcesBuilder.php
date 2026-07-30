<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\PaymentLinkRelatedResources;

/**
 * Builder for model PaymentLinkRelatedResources
 *
 * @see PaymentLinkRelatedResources
 */
class PaymentLinkRelatedResourcesBuilder
{
    /**
     * @var PaymentLinkRelatedResources
     */
    private $instance;

    private function __construct(PaymentLinkRelatedResources $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new payment link related resources Builder object.
     */
    public static function init(): self
    {
        return new self(new PaymentLinkRelatedResources());
    }

    /**
     * Sets orders field.
     */
    public function orders(?array $value): self
    {
        $this->instance->setOrders($value);
        return $this;
    }

    /**
     * Unsets orders field.
     */
    public function unsetOrders(): self
    {
        $this->instance->unsetOrders();
        return $this;
    }

    /**
     * Sets subscription plans field.
     */
    public function subscriptionPlans(?array $value): self
    {
        $this->instance->setSubscriptionPlans($value);
        return $this;
    }

    /**
     * Unsets subscription plans field.
     */
    public function unsetSubscriptionPlans(): self
    {
        $this->instance->unsetSubscriptionPlans();
        return $this;
    }

    /**
     * Initializes a new payment link related resources object.
     */
    public function build(): PaymentLinkRelatedResources
    {
        return CoreHelper::clone($this->instance);
    }
}
