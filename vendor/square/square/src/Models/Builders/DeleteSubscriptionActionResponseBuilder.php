<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteSubscriptionActionResponse;
use Square\Models\Subscription;

/**
 * Builder for model DeleteSubscriptionActionResponse
 *
 * @see DeleteSubscriptionActionResponse
 */
class DeleteSubscriptionActionResponseBuilder
{
    /**
     * @var DeleteSubscriptionActionResponse
     */
    private $instance;

    private function __construct(DeleteSubscriptionActionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete subscription action response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteSubscriptionActionResponse());
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
     * Sets subscription field.
     */
    public function subscription(?Subscription $value): self
    {
        $this->instance->setSubscription($value);
        return $this;
    }

    /**
     * Initializes a new delete subscription action response object.
     */
    public function build(): DeleteSubscriptionActionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
