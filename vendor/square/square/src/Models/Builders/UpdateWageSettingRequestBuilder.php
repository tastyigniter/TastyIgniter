<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateWageSettingRequest;
use Square\Models\WageSetting;

/**
 * Builder for model UpdateWageSettingRequest
 *
 * @see UpdateWageSettingRequest
 */
class UpdateWageSettingRequestBuilder
{
    /**
     * @var UpdateWageSettingRequest
     */
    private $instance;

    private function __construct(UpdateWageSettingRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update wage setting request Builder object.
     */
    public static function init(WageSetting $wageSetting): self
    {
        return new self(new UpdateWageSettingRequest($wageSetting));
    }

    /**
     * Initializes a new update wage setting request object.
     */
    public function build(): UpdateWageSettingRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
