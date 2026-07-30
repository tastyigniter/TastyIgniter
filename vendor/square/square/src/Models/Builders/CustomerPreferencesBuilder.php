<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerPreferences;

/**
 * Builder for model CustomerPreferences
 *
 * @see CustomerPreferences
 */
class CustomerPreferencesBuilder
{
    /**
     * @var CustomerPreferences
     */
    private $instance;

    private function __construct(CustomerPreferences $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer preferences Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerPreferences());
    }

    /**
     * Sets email unsubscribed field.
     */
    public function emailUnsubscribed(?bool $value): self
    {
        $this->instance->setEmailUnsubscribed($value);
        return $this;
    }

    /**
     * Unsets email unsubscribed field.
     */
    public function unsetEmailUnsubscribed(): self
    {
        $this->instance->unsetEmailUnsubscribed();
        return $this;
    }

    /**
     * Initializes a new customer preferences object.
     */
    public function build(): CustomerPreferences
    {
        return CoreHelper::clone($this->instance);
    }
}
