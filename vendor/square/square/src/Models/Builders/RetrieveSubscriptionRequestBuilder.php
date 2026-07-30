<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveSubscriptionRequest;

/**
 * Builder for model RetrieveSubscriptionRequest
 *
 * @see RetrieveSubscriptionRequest
 */
class RetrieveSubscriptionRequestBuilder
{
    /**
     * @var RetrieveSubscriptionRequest
     */
    private $instance;

    private function __construct(RetrieveSubscriptionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve subscription request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveSubscriptionRequest());
    }

    /**
     * Sets include field.
     */
    public function include(?string $value): self
    {
        $this->instance->setInclude($value);
        return $this;
    }

    /**
     * Unsets include field.
     */
    public function unsetInclude(): self
    {
        $this->instance->unsetInclude();
        return $this;
    }

    /**
     * Initializes a new retrieve subscription request object.
     */
    public function build(): RetrieveSubscriptionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
