<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SubscriptionSource;

/**
 * Builder for model SubscriptionSource
 *
 * @see SubscriptionSource
 */
class SubscriptionSourceBuilder
{
    /**
     * @var SubscriptionSource
     */
    private $instance;

    private function __construct(SubscriptionSource $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription source Builder object.
     */
    public static function init(): self
    {
        return new self(new SubscriptionSource());
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Initializes a new subscription source object.
     */
    public function build(): SubscriptionSource
    {
        return CoreHelper::clone($this->instance);
    }
}
