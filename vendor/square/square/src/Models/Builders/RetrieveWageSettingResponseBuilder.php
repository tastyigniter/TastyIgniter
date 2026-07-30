<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveWageSettingResponse;
use Square\Models\WageSetting;

/**
 * Builder for model RetrieveWageSettingResponse
 *
 * @see RetrieveWageSettingResponse
 */
class RetrieveWageSettingResponseBuilder
{
    /**
     * @var RetrieveWageSettingResponse
     */
    private $instance;

    private function __construct(RetrieveWageSettingResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve wage setting response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveWageSettingResponse());
    }

    /**
     * Sets wage setting field.
     */
    public function wageSetting(?WageSetting $value): self
    {
        $this->instance->setWageSetting($value);
        return $this;
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
     * Initializes a new retrieve wage setting response object.
     */
    public function build(): RetrieveWageSettingResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
