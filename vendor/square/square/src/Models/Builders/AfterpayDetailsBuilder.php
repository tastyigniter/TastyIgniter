<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AfterpayDetails;

/**
 * Builder for model AfterpayDetails
 *
 * @see AfterpayDetails
 */
class AfterpayDetailsBuilder
{
    /**
     * @var AfterpayDetails
     */
    private $instance;

    private function __construct(AfterpayDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new afterpay details Builder object.
     */
    public static function init(): self
    {
        return new self(new AfterpayDetails());
    }

    /**
     * Sets email address field.
     */
    public function emailAddress(?string $value): self
    {
        $this->instance->setEmailAddress($value);
        return $this;
    }

    /**
     * Unsets email address field.
     */
    public function unsetEmailAddress(): self
    {
        $this->instance->unsetEmailAddress();
        return $this;
    }

    /**
     * Initializes a new afterpay details object.
     */
    public function build(): AfterpayDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
