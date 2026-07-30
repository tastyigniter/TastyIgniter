<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWageSettingResponse;
use Square\Models\WageSetting;

/**
 * Builder for model UpdateWageSettingResponse
 *
 * @see UpdateWageSettingResponse
 */
class UpdateWageSettingResponseBuilder
{
    /**
     * @var UpdateWageSettingResponse
     */
    private $instance;

    private function __construct(UpdateWageSettingResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update wage setting response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateWageSettingResponse());
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
     * Initializes a new update wage setting response object.
     */
    public function build(): UpdateWageSettingResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
