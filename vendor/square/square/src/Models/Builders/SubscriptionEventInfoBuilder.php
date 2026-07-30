<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SubscriptionEventInfo;

/**
 * Builder for model SubscriptionEventInfo
 *
 * @see SubscriptionEventInfo
 */
class SubscriptionEventInfoBuilder
{
    /**
     * @var SubscriptionEventInfo
     */
    private $instance;

    private function __construct(SubscriptionEventInfo $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new subscription event info Builder object.
     */
    public static function init(): self
    {
        return new self(new SubscriptionEventInfo());
    }

    /**
     * Sets detail field.
     */
    public function detail(?string $value): self
    {
        $this->instance->setDetail($value);
        return $this;
    }

    /**
     * Unsets detail field.
     */
    public function unsetDetail(): self
    {
        $this->instance->unsetDetail();
        return $this;
    }

    /**
     * Sets code field.
     */
    public function code(?string $value): self
    {
        $this->instance->setCode($value);
        return $this;
    }

    /**
     * Initializes a new subscription event info object.
     */
    public function build(): SubscriptionEventInfo
    {
        return CoreHelper::clone($this->instance);
    }
}
